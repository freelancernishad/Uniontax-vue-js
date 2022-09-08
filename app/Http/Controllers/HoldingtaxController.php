<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Holdingtax;
use Illuminate\Http\Request;
use App\Models\HoldingBokeya;

class HoldingtaxController extends Controller
{
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


        return HoldingBokeya::find($r->id)->update(['status'=>'Paid']);

        $taxData = DB::table('holdingtaxs')->where('id', $id)->get();
        $items = json_decode($taxData[0]->bokeya);
        $j = 0;
        foreach ($items as $list) {
            if ($list->itemId == $itemId) {
                $status = 'Paid';
            } else {
                $status = $list->status;
            }
            $array[$j] = [
                'itemId' => $list->itemId,
                'year' => $list->year,
                'price' => $list->price,
                'status' => $status,
            ];
            $j++;
        }
        /* echo '<pre>';
       print_r($array); */
        $bokeya = json_encode($array);
        $data = [
            'bokeya'     => $bokeya,
        ];
        DB::table('holdingtaxs')->where('id', $id)->update($data);
        //return redirect('/admin/holding_tax/list/'.$word);
        return redirect("/invoice/holdintax/$id/$itemId/$word");
    }
}
