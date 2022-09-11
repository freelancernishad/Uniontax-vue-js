<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Holdingtax;
use Illuminate\Http\Request;
use App\Models\HoldingBokeya;
use App\Models\TaxInvoice;
use App\Models\Uniouninfo;
use Rakibhstu\Banglanumber\NumberToBangla;

class HoldingtaxController extends Controller
{

    public function holdingPaymentInvoice(Request $request,$id)
    {

        $holdingBokeya = HoldingBokeya::find($id);
        $payYear = $holdingBokeya->payYear;
        $holdingTax_id = $holdingBokeya->holdingTax_id;
        $holdingTax = Holdingtax::find($holdingTax_id);
        $union = $holdingTax->unioun;
        $unions = Uniouninfo::where(['short_name_e'=>$union])->first();
        $holdingBokeyas = HoldingBokeya::where(['holdingTax_id'=>$holdingTax_id,'payYear'=>$payYear])->get();

        $holdingBokeyasAmount = HoldingBokeya::where(['holdingTax_id'=>$holdingTax_id,'payYear'=>$payYear])->sum('price');

        $TaxInvoicecount =  TaxInvoice::where(['holdingTax_id'=>$holdingTax_id,'PayYear'=>$payYear])->count();

        if($TaxInvoicecount>0){
               $TaxInvoice =  TaxInvoice::where(['holdingTax_id'=>$holdingTax_id,'PayYear'=>$payYear])->first();
               $invoice=[
                'totalAmount'=>$holdingBokeyasAmount,
                ];
               $TaxInvoice->update($invoice);
        }else{

            $invoice=[
                'invoiceId'=>'sdfsdf',
                'holdingTax_id'=>$holdingTax_id,
                'PayYear'=>$payYear,
                'totalAmount'=>$holdingBokeyasAmount,
            ];
            TaxInvoice::create($invoice);
        }

        $TaxInvoice =  TaxInvoice::where(['holdingTax_id'=>$holdingTax_id,'PayYear'=>$payYear])->first();

        $holdingTax = Holdingtax::find($TaxInvoice->holdingTax_id);
        $union = $holdingTax->unioun;
        $unions = Uniouninfo::where(['short_name_e'=>$union])->first();
        $holdingBokeyas = HoldingBokeya::where(['holdingTax_id'=>$holdingTax_id,'payYear'=>$payYear])->get();

        // die();
        $amounts = number_format($TaxInvoice->totalAmount,2);

        $numto = new NumberToBangla();
        $amount = $numto->bnMoney((float)$amounts);

        $fileName = 'Invoice-'.date('Y-m-d H:m:s');
        $data['fileName'] = $fileName;
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L','default_font' => 'bangla',]);
        $mpdf->WriteHTML( $this->invoice1($holdingTax,$unions,$amount,$holdingBokeyas,'right',$TaxInvoice));
        $mpdf->Output($fileName,'I');

    }








    public function invoice1($customers,$unions,$amount,$bokeyas,$float,$TaxInvoice){

        $full_name = $unions->full_name;
        $thana = $unions->thana;
        $district = $unions->district;


        $maliker_name = $customers->maliker_name;
        $gramer_name = $customers->gramer_name;

        $invoiceId = $TaxInvoice->invoiceId;
        $created_at = date("d/m/Y", strtotime($TaxInvoice->created_at));
        $subtotal = number_format($TaxInvoice->totalAmount,2);

        // <div style='text-align:right'>(ডিলারের কপি)</div>
        $html = "

        <style>
        @page {
            margin: 10px;
           }

        .memoborder{
            width: 48%;
        }

        .memobg {

            padding: 10px;
            position: relative;
            background: linear-gradient(42deg, rgba(163, 92, 33, 1) 0%, rgba(147, 61, 83, 1) 11%, rgba(67, 120, 108, 1) 24%, rgba(28, 140, 194, 1) 33%, rgba(88, 132, 157, 1) 42%, rgba(135, 119, 143, 1) 51%, rgba(162, 87, 145, 1) 61%, rgba(180, 126, 20, 1) 71%, rgba(190, 155, 49, 1) 80%, rgba(195, 113, 90, 1) 89%, rgba(111, 137, 52, 1) 98%);
            /* padding: 3px; */

        }
        .memo {
        //    width: 500px;
        //    margin:0 auto;
        //    padding:20px;
            background: white;

        }



        .memoHead {
            text-align: center;
            color:#444B8F
        }
        h1.companiname {
            transform: scaleX(2);
            margin:0;
        }
        p {

            color:#444B8F;
            margin:0;

        }div {

            color:#444B8F;
            margin:0;

        }
        p.defalttext.address {
            background:#444B8F;
            width: 269px;
            margin: 0 auto;
            color: white;
            border-radius: 50px;
            padding: 2px 0px;
        }
        p.defalttext {
            font-weight: 600;
            font-size: 16px;
            margin: 0;
            /* transform: scaleX(1.2); */

        }


        thead tr {
            background: #444B8F;
        }
        thead tr th {
            color: white;
        }

        tr {
            border: 1px solid #444B8F;
        }

        th {
            border: 1px solid #444B8F;
            border-right: 1px solid white;
        }

        td {
            border: 1px solid #444B8F;
        }
        table,  td {
          border: 1px solid #444B8F;
          border-collapse: collapse;
          text-align: center;
          color:#444B8F;
        }th, {
          border: 1px solid white;
          border-collapse: collapse;
        }

        td {
            height: 18.5px;

        }
        .slNo{
            float: right;
            width: 300px;
        }
        </style>


    <div id='body'>

    <div class='memoborder' style='float:left' >
    <div class='memobg memobg1'>
            <div class='memo'>
            <div class='memoHead'>

            <img width='50px' style='margin-top:10px' src='".base64('assets/img/bangladesh-govt.png')."' />

            <p class='defalttext'>গণপ্রজাতন্ত্রী বাংলাদেশ</p>
            <h1 class='companiname'>$full_name</h1>
            <p class='defalttext'>উপজেলা: $thana, জেলা: $district  ।</p>
            <p class='defalttext address'>হোল্ডিং ট্যাক্স </p>


            <div style='display:flex; margin-top:20px'>

            </div>

        </div>

                <div class='memobody' style='position: relative;'>
                    <table width='100%' style='border: 1px solid #2F77A5;margin-bottom:20px' cellspacing='0'>
                        <tr>
                            <td style='background:#2F77A5;padding:10px 5px;color:white;padding:5px 5px;width:15%;float:left;border-bottom:1px solid #2F77A5;text-align:left'
                                class='defaltfont'>নাম</td>
                            <td style='border-bottom:1px solid #2F77A5;padding-left:6px;color:#2F77A5;text-align:left'
                                class='defaltfont'> $maliker_name </td>
                            <td width='10%'
                                style='background:#2F77A5;padding:10px 5px;color:white;padding:5px 5px;width:15%;float:left;border-bottom:1px solid #2F77A5;text-align:left'
                                class='defaltfont'>ক্রমিক নং</td>
                            <td width='20%' style='border-bottom:1px solid #2F77A5;padding-left:6px;color:#2F77A5;text-align:left'
                                class='defaltfont'>$invoiceId</td>
                        </tr>
                        <tr>
                            <td style='background:#935E6C;padding:10px 5px;color:white;padding:5px 5px;width:15%;float:left;text-align:left'
                                class='defaltfont'>ঠিকানা</td>
                            <td class='defaltfont' style='padding-left:6px;color:#2F77A5;text-align:left'> $gramer_name</td>
                            <td style='background:#935E6C;padding:10px 5px;color:white;padding:5px 5px;width:15%;float:left;text-align:left'
                                class='defaltfont'>তারিখ</td>
                            <td class='defaltfont' style='padding-left:6px;color:#2F77A5;text-align:left'>".int_en_to_bn($created_at)."
                            </td>
                        </tr>
                    </table>
                    <div class='productDetails'>
                        <table class='table' style='border:1px solid #444B8F;width:100%' cellspacing='0'>
                            <thead class='thead'>
                                <tr class='tr'>
                                    <th class='th defaltfont' width='10%'>ক্রমিক নং</th>
                                    <th class='th defaltfont' width='45%'>অর্থ বছর</th>

                                    <th class='th defaltfont' width='15%'>টাকা</th>
                                </tr>
                            </thead>
                            <tbody class='tbody'>";



                                    // $totalpay = $orders->pay;
                                    // $totaldue = $orders->due;
                                    $index = 1;

                                // $orderDetails = json_decode($orders->Invoices);

                                foreach($bokeyas as $bokeya){
                                  $html .="  <tr class='tr'>
                                        <td class='td defaltfont'>".int_en_to_bn($index)."</td>
                                        <td class='td defaltfont'>".int_en_to_bn($bokeya->year)."</td>
                                        <td class='td defaltfont'>".int_en_to_bn($bokeya->price)."</td>
                                    </tr>";

                                        $index++;
                                        // $subtotal += $product->pay;

                                }


                                    $totalrow = 16-$index;
                                    for ($i=0; $i <$totalrow ; $i++) {
                                        $html .=" <tr class='tr'>
                                        <td class='td defaltfont'>".int_en_to_bn($i+$index)."</td>
                                        <td class='td defaltfont'></td>
                                        <td class='td defaltfont'></td>
                                    </tr>";
                                    }



                                $html .=" </tbody>
                            <tfoot class='tfoot'>";





                            $html .="
                            <tr class='tr'>
                            <td colspan='2' class='defalttext td defaltfont'style='text-align:right;    padding: 0 13px;'><p> মোট </p></td>
                            <td class='td defaltfont'>".int_en_to_bn($subtotal)."</td>
                    </tr>


                            ";








                                $html .=" </tfoot>
                        </table>
                        <p style='margin-top:15px;padding:0 15px;' class='defaltfont'>কথায় : $amount</p>

                    </div>
                </div>
                <div class='memofooter' style='margin-top:25px'>
                    <p style='float:left;width:30%;padding:10px 15px' class='defaltfont'>ক্রেতার স্বাক্ষর</p>

                    <p style='float:right;width:30%;text-align:right;padding:10px 15px' class='defaltfont'>বিক্রেতার
                    স্বাক্ষর</p>
                </div>
            </div>
        </div>
        </div>




        </div>



        ";


        return $html;
    }

















    public function int_bn_to_en($number)
    {
        $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
        $en_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($bn_digits, $en_digits, $number);
    }
    public function index(Request $r)
    {
        $word = $r->word;
        $union = $r->union;
        if(!$word && !$union){

            return Holdingtax::all();
        }
        if(!$word){

            return Holdingtax::where(['unioun' => $union])->get();
        }
        return Holdingtax::where(['unioun' => $union, 'word_no' => $word])->get();
    }
    public function show(Request $r,$id)
    {

        return Holdingtax::find($id);
    }
    public function store(Request $r)
    {
        // return $r->all();
        //  echo '<pre>';
        //  print_r($r->input());
        $griher_barsikh_mullo = $this->int_bn_to_en($r->griher_barsikh_mullo);
        $jomir_vara = $this->int_bn_to_en($r->jomir_vara);
        $barsikh_vara = $this->int_bn_to_en($r->barsikh_vara);
        $category = $r->category;
        if ($category == 'মালিক নিজে বসবাসকারী') {
            //বার্ষিক মূল্যের 7.5%
            $barsikh_muller_percent = ($griher_barsikh_mullo * 7.5) / 100;
            //মোট মূল্য
            $total_mullo = $jomir_vara + $barsikh_muller_percent;
            //রক্ষণাবেক্ষণ খরচ
            $rokhona_bekhon_khoroch = $total_mullo / 6;
            // প্রাক্কলিত মূল্য
            $prakklito_mullo = $total_mullo - $rokhona_bekhon_khoroch;
            // রেয়াত
            $reyad = $prakklito_mullo / 4;
            // প্রদেয় করযোগ্য বার্ষিক মূল্য
            $prodey_korjoggo_barsikh_mullo = $prakklito_mullo - $reyad;
            // নির্ধারিত হোল্ডিং কর (৭%)
            $current_year_kor = ($prodey_korjoggo_barsikh_mullo * 7) / 100;
            if ($current_year_kor >= 500) {
                $current_year_kor = 500;
            } else {
                $current_year_kor = $current_year_kor;
            }
            //echo $current_year_kor;
            //আংশিক প্রদেয় করযোগ্য
            $angsikh_prodoy_korjoggo_barsikh_mullo = '';
            //রক্ষণাবেক্ষণ খরচ (6%)
            $rokhona_bekhon_khoroch_percent = '';
            //প্রদেয় করযোগ্য বার্ষিক ভাড়ার মূল্য
            $prodey_korjoggo_barsikh_varar_mullo = '';
            //মোট প্রদেয় করযোগ্য বার্ষিক মূল্য
            $total_prodey_korjoggo_barsikh_mullo = '';
        } else if ($category == 'প্রতিষ্ঠান') {
            //বার্ষিক মূল্যের 7.5%
            $barsikh_muller_percent = ($griher_barsikh_mullo * 7.5) / 100;
            //মোট মূল্য
            $total_mullo = $jomir_vara + $barsikh_muller_percent;
            //রক্ষণাবেক্ষণ খরচ
            $rokhona_bekhon_khoroch = $total_mullo / 6;
            // প্রাক্কলিত মূল্য
            $prakklito_mullo = $total_mullo - $rokhona_bekhon_khoroch;
            // রেয়াত
            $reyad = $prakklito_mullo / 4;
            // প্রদেয় করযোগ্য বার্ষিক মূল্য
            $prodey_korjoggo_barsikh_mullo = $prakklito_mullo - $reyad;
            // নির্ধারিত হোল্ডিং কর (৭%)
            $current_year_kor = ($prodey_korjoggo_barsikh_mullo * 7) / 100;
            //আংশিক প্রদেয় করযোগ্য
            $angsikh_prodoy_korjoggo_barsikh_mullo = '';
            //রক্ষণাবেক্ষণ খরচ (6%)
            $rokhona_bekhon_khoroch_percent = '';
            //প্রদেয় করযোগ্য বার্ষিক ভাড়ার মূল্য
            $prodey_korjoggo_barsikh_varar_mullo = '';
            //মোট প্রদেয় করযোগ্য বার্ষিক মূল্য
            $total_prodey_korjoggo_barsikh_mullo = '';
        } else if ($category == 'ভাড়া') {
            //ভারা
            //বার্ষিক ভাড়ার মূল্যের
            //রক্ষণাবেক্ষণ খরচ ৬%
            // প্রদেয় করযোগ্য বার্ষিক মূল্য = বার্ষিক ভাড়ার মূল্যের - রক্ষণাবেক্ষণ খরচ
            // নির্ধারিত হোল্ডিং কর (৭%) =  প্রদেয় করযোগ্য বার্ষিক মূল্য৭%
            //বার্ষিক মূল্যের 7.5%
            $barsikh_muller_percent = '';
            //মোট মূল্য
            $total_mullo = '';
            //রক্ষণাবেক্ষণ খরচ
            $rokhona_bekhon_khoroch = '';
            // প্রাক্কলিত মূল্য
            $prakklito_mullo = '';
            // রেয়াত
            $reyad = '';
            // প্রদেয় করযোগ্য বার্ষিক মূল্য
            $prodey_korjoggo_barsikh_mullo = '';
            //আংশিক প্রদেয় করযোগ্য
            $angsikh_prodoy_korjoggo_barsikh_mullo = '';
            //রক্ষণাবেক্ষণ খরচ (6%)
            $rokhona_bekhon_khoroch_percent = $barsikh_vara / 6;;
            //প্রদেয় করযোগ্য বার্ষিক ভাড়ার মূল্য
            $prodey_korjoggo_barsikh_varar_mullo = $barsikh_vara - $rokhona_bekhon_khoroch_percent;
            //মোট প্রদেয় করযোগ্য বার্ষিক মূল্য
            $total_prodey_korjoggo_barsikh_mullo = '';
            // নির্ধারিত হোল্ডিং কর (৭%)
            $current_year_kor = ($prodey_korjoggo_barsikh_varar_mullo * 7) / 100;
            if ($current_year_kor >= 500) {
                $current_year_kor = 500;
            } else {
                $current_year_kor = $current_year_kor;
            }
            //echo $current_year_kor;
        } else if ($category == 'আংশিক ভাড়া') {
            //বার্ষিক মূল্যের 7.5%
            $barsikh_muller_percent = ($griher_barsikh_mullo * 7.5) / 100;
            //মোট মূল্য
            $total_mullo = $jomir_vara + $barsikh_muller_percent;
            //রক্ষণাবেক্ষণ খরচ
            $rokhona_bekhon_khoroch = $total_mullo / 6;
            // প্রাক্কলিত মূল্য
            $prakklito_mullo = $total_mullo - $rokhona_bekhon_khoroch;
            // রেয়াত
            $reyad = $prakklito_mullo / 4;
            // প্রদেয় করযোগ্য বার্ষিক মূল্য
            $prodey_korjoggo_barsikh_mullo = '';
            //আংশিক প্রদেয় করযোগ্য
            $angsikh_prodoy_korjoggo_barsikh_mullo = $prakklito_mullo - $reyad;
            //রক্ষণাবেক্ষণ খরচ (6%)
            $rokhona_bekhon_khoroch_percent = $barsikh_vara / 6;
            //প্রদেয় করযোগ্য বার্ষিক ভাড়ার মূল্য
            $prodey_korjoggo_barsikh_varar_mullo = $barsikh_vara - $rokhona_bekhon_khoroch_percent;
            //মোট প্রদেয় করযোগ্য বার্ষিক মূল্য
            $total_prodey_korjoggo_barsikh_mullo = $angsikh_prodoy_korjoggo_barsikh_mullo + $prodey_korjoggo_barsikh_varar_mullo;
            // নির্ধারিত হোল্ডিং কর (৭%)
            $current_year_kor = ($total_prodey_korjoggo_barsikh_mullo * 7) / 100;
            if ($current_year_kor >= 500) {
                $current_year_kor = 500;
            } else {
                $current_year_kor = $current_year_kor;
            }
            //echo $current_year_kor;
        }

        //die();
        //ভারা
        //বার্ষিক ভাড়ার মূল্যের
        //রক্ষণাবেক্ষণ খরচ ৬%
        // প্রদেয় করযোগ্য বার্ষিক মূল্য = বার্ষিক ভাড়ার মূল্যের - রক্ষণাবেক্ষণ খরচ
        // নির্ধারিত হোল্ডিং কর (৭%) =  প্রদেয় করযোগ্য বার্ষিক মূল্য৭%
        //মালিক + ভাড়া
        //গৃহের বার্ষিক  মূল্য
        //বার্ষিক মূল্যের 7.5%
        //জমির ভাড়া
        //মোট মূল্য
        //রক্ষণাবেক্ষণ খরচ
        //প্রাক্কলিত মূল্য
        //রেয়াত
        //আংশিক প্রদেয় করযোগ্য = প্রাক্কলিত মূল্য -রেয়াত
        //বার্ষিক ভাড়ার = ইনপুট
        //রক্ষণাবেক্ষণ খরচ (6%)  = বার্ষিক ভাড়ার ৬%
        //প্রদেয় করযোগ্য বার্ষিক ভাড়ার মূল্য  = বার্ষিক ভাড়ার -রক্ষণাবেক্ষণ খরচ
        //মোট প্রদেয় করযোগ্য বার্ষিক মূল্য  = আংশিক প্রদেয় করযোগ্য + প্রদেয় করযোগ্য বার্ষিক ভাড়ার মূল্য
        // নির্ধারিত হোল্ডিং কর (৭%) = মোট প্রদেয় করযোগ্য বার্ষিক মূল্য৭%


$total_bokeya = 0;
        foreach ($r->bokeya as  $value) {
           $total_bokeya += $value['price'];

        }

        $bokeya = json_encode($r->bokeya);

        $total_bokeya = $current_year_kor + $total_bokeya;




         $data = $r->except('bokeya');
      $data['bokeya'] = $bokeya;
      $data['total_bokeya'] = $total_bokeya;
      $data['barsikh_muller_percent'] = $barsikh_muller_percent;
      $data['total_mullo'] = $total_mullo;
      $data['rokhona_bekhon_khoroch'] = $rokhona_bekhon_khoroch;
      $data['prakklito_mullo'] = $prakklito_mullo;
      $data['reyad'] = $reyad;
      $data['angsikh_prodoy_korjoggo_barsikh_mullo'] = $angsikh_prodoy_korjoggo_barsikh_mullo;
      $data['barsikh_vara'] = $barsikh_vara;
      $data['rokhona_bekhon_khoroch_percent'] = $rokhona_bekhon_khoroch_percent;
      $data['prodey_korjoggo_barsikh_mullo'] = $prodey_korjoggo_barsikh_mullo;
      $data['prodey_korjoggo_barsikh_varar_mullo'] = $prodey_korjoggo_barsikh_varar_mullo;
      $data['total_prodey_korjoggo_barsikh_mullo'] = $total_prodey_korjoggo_barsikh_mullo;
      $data['current_year_kor'] = $current_year_kor;

        $holding =  Holdingtax::create($data);
        $curentdata = [
            'holdingTax_id'=>$holding->id,
            'year'=>"2022 2023",
            'price'=>$current_year_kor,
            'status'=>'Unpaid'
        ];
        HoldingBokeya::create($curentdata);

$total_bokeya = 0;
        foreach ($r->bokeya as  $value) {
           $total_bokeya += $value['price'];
            $bokeyadata = [
                'holdingTax_id'=>$holding->id,
                'year'=>$value['year'],
                'price'=>$value['price'],
                'status'=>'Unpaid'
            ];
            HoldingBokeya::create($bokeyadata);


        }




    }

    public function holding_tax_pay_Online(Request $request,$id)
    {
        $holdingBokeya = HoldingBokeya::find($id);
        $trnx_id = time();
        $cust_info = [
            "cust_email" => "",
            "cust_id" => "$holdingBokeya->id",
            "cust_mail_addr" => "Address",
            "cust_mobo_no" => "01909756552",
            "cust_name" => "Customer Name"
        ];
        $holdingTax = Holdingtax::where(['id'=>$holdingBokeya->holdingTax_id])->first();
        $req_timestamp = date('Y-m-d H:i:s');
        $customerData = [
            'union' => $holdingTax->unioun,
            'trxId' => $trnx_id,
            'sonodId' => $id,
            'sonod_type' => 'holdingtax',
            'amount' => $holdingBokeya->price,
            'mob' => "01909756552",
            'status' => "Pending",
            'created_at' => $req_timestamp,
        ];
        Payment::create($customerData);

         $redirectutl =  ekpayToken($trnx_id, $holdingBokeya->price, $cust_info,'holdingPay');
        echo "
        <script>
            window.location.href='$redirectutl'
        </script>

        ";

    }

        public function holdingPaymentSuccess(Request $request)
        {
            // return $request->all();
            $transId = $request->transId;
            $payment = Payment::where(['trxId'=>$transId])->first();
            $payment->update(['status'=>'Paid']);
            $holdingBokeya = HoldingBokeya::find($payment->sonodId);

            $holdingBokeya->update(['status'=>'Paid']);
            $redirectutl = url("/holding/tax/$holdingBokeya->holdingTax_id");
            echo "
            <script>
                window.location.href='$redirectutl'
            </script>

            ";

        }



    public function holding_tax_Delete($id, $word)
    {
        DB::table('holdingtaxs')->where('id', $id)->delete();
        return redirect('/admin/holding_tax/list/' . $word);
    }
    public function holding_tax_view(Request $r, $id, $word)
    {
        $data['word'] = $word;
        $data['name'] = 'হোল্ডিং ট্যাক্স';
        $data['result'] = DB::table('holdingtaxs')->where('id', $id)->get();
        return view('mainAdmin/holdingTax.view', $data);
    }
    public function holding_tax_pay(Request $r)
    {

        return HoldingBokeya::find($r->id)->update(['status'=>'Paid','payYear'=>date('Y')]);


    }
}
