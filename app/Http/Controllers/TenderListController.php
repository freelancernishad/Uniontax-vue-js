<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\Payment;
use App\Models\TenderFormBuy;
use App\Models\TenderList;
use App\Models\Uniouninfo;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Rakibhstu\Banglanumber\NumberToBangla;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;



class TenderListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $union_name = $request->union_name;
        $status = $request->status;
        if($union_name && $status){
            return TenderList::where(['union_name'=>$union_name,'status'=>$status])->orderBy('id','desc')->get();
        }
        if($union_name){
            return TenderList::where('union_name',$union_name)->orderBy('id','desc')->get();
        }


        return TenderList::orderBy('id','desc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datas = $request->all();
        $random = Str::random(20);
        $datas['tender_id'] = time().$random;
        $datas['status'] = 'pending';

        return TenderList::create($datas);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TenderList  $tenderList
     * @return \Illuminate\Http\Response
     */
    public function show(TenderList $tenderList,$id)
    {
        return TenderList::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TenderList  $tenderList
     * @return \Illuminate\Http\Response
     */
    public function edit(TenderList $tenderList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TenderList  $tenderList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TenderList $tenderList,$id)
    {
        $datas = $request->all();

        $tenderList = TenderList::find($id);

        $tenderList->update($datas);

         return $tenderList;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TenderList  $tenderList
     * @return \Illuminate\Http\Response
     */
    public function destroy(TenderList $tenderList)
    {
       $tenderList->delete();
       return 1;
    }


    public function viewpdf(Request $request, $tender_id)
    {



        ini_set('max_execution_time', '60000');
        ini_set("pcre.backtrack_limit", "50000000000000000");
        ini_set('memory_limit', '12008M');

        // $pdf = LaravelMpdf::loadView('tender.notice');
        // return $pdf->stream("fghfg.pdf");


        $tender_list_count = TenderList::where('tender_id',$tender_id)->count();
        if($tender_list_count<1){
            return 'No data Found';
        }

        $row = TenderList::where('tender_id',$tender_id)->first();



        $uniouninfo = Uniouninfo::where('short_name_e', $row->union_name)->first();

        $filename = time().".pdf";

            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 13,
                'default_font' => 'bangla',
                'mode' => 'utf-8',
                'format' => 'A4',
                'setAutoTopMargin' => 'stretch',
                'setAutoBottomMargin' => 'stretch'
            ]);
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetHTMLHeader($this->pdfHeader($row,$uniouninfo, $filename));
            $mpdf->SetHTMLFooter($this->pdfFooter($row,$uniouninfo, $filename));
            // $mpdf->SetHTMLHeader('Document Title|Center Text|{PAGENO}');
            $mpdf->defaultheaderfontsize = 10;
            $mpdf->defaultheaderfontstyle = 'B';
            $mpdf->defaultheaderline = 0;
            $mpdf->defaultfooterfontsize = 10;
            $mpdf->defaultfooterfontstyle = 'BI';
            $mpdf->defaultfooterline = 0;
            $mpdf->showWatermarkImage = true;
            // $mpdf->WriteHTML('<watermarkimage src="'.$watermark.'" alpha="0.1" size="80,80" />');
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->WriteHTML($this->pdfHTMLut($row,$uniouninfo));
            $mpdf->useSubstitutions = false;
            $mpdf->simpleTables = true;
            $mpdf->Output($filename, 'I');

    }

    public function pdfHTMLut($row,$uniouninfo)
    {

        $created_at = $row->created_at;
        $month = date('m', strtotime($created_at));
        $MYear = date('Y');
        $Mmonth = date('m');
        $Mdate = date('d');
        if($month>7){

            $meyad = "০১/০৭/".int_en_to_bn($MYear);
            $orthoBotsor = int_en_to_bn($MYear."-".$MYear+1);

        }else{
            $meyad = "০১/০৭/".int_en_to_bn($MYear-1);
            $orthoBotsor = int_en_to_bn($MYear-1 ."-".$MYear);
        }
        $form_price = $row->form_price;

        $numto = new NumberToBangla();
        $the_amount_of_money_in_words = $numto->bnMoney($form_price) . ' মাত্র';

        $nagoriinfo = "
            <table width='100%'>
                <tr>
                    <td style='text-align:left'>স্মারক নং:- ".int_en_to_bn($row->memorial_no)."</td>
                    <td style='text-align:right'>তারিখ:- ".int_en_to_bn(date('d/m/Y', strtotime($created_at)))."</td>
                </tr>
            </table>
            <p style='text-align:center;text-weight:700'><u>$row->tender_name</u></p>


            <p>
             &nbsp;&nbsp;&nbsp;&nbsp;

             এতদ্বারা সর্বসাধারণের সদয় অবগতির জন্য জানানো যাচ্ছে যে, ইউনিয়ন পরিষদের মালিকানাধীন $row->tender_type $orthoBotsor সনের জন্য অর্থাৎ $meyad খ্রি: হতে এক বৎসর মেয়াদে ইজারার নিমিত্তে সিলগালা খামে দরপত্র আহবান করা যাচ্ছে। দরপত্র সিডিউলে উল্লেখিত শর্তাবলী পালন সাপেক্ষে দরপত্রসমূহ নিম্নলিখিত তারিখ ও সময়ে কেবল মাত্র $uniouninfo->full_name কার্যালয়ে রক্ষিত দরপত্র বাক্সে ".int_en_to_bn(date('d/m/Y h:i', strtotime($row->tender_end)))." ঘটিকা পর্যন্ত গ্রহণ করা হবে। ঐদিনই ".int_en_to_bn(date('d/m/Y h:i', strtotime($row->tender_open)))." ঘটিকার সময় উপস্থিত দরপত্র দাতা কিংবা তাদের প্রতিনিধিদের সম্মুখে (যদি কেহ উপস্থিত থাকেন) খোলা হবে। দরপত্র সংক্রান্ত যাবতীয় তথ্যাদি, দরপত্র সিডিউল/দলিলাদি দরপত্র গ্রহণের পূর্বদিন পর্যন্ত অফিস চলাকালীন সময়ে ".int_en_to_bn($form_price)."/- ($the_amount_of_money_in_words) মূল্যে (অফেরত যোগ্য) $uniouninfo->full_name অফিসে ও সংশ্লিষ্ট উপজেলা নিবাহী অফিসারের কার্যালয় হইতে ক্রয় করা যাবে। দরপত্র দাখিলের দিন কোন দরপত্র সিডিউল বিক্রি করা হবে না। বিগত বছরের ইজারা মূল্য ও অন্যান্য তথ্যাদি $uniouninfo->full_name এর ওয়েবসাইট (www.uniontax.gov.bd) থেকে এবং অফিস চলাকালীন সময়ে অফিস হতে জানা যাবে




</p>

             <p style='text-align:center;text-weight:700'><u>দরপত্র গ্রহণের তারিখ</u></p>

             <table width='100%' border='1' style='border-collapse:collapse;'>

                <tr>
                    <td style='text-align:center' width='8%'>ক্রমিক</td>
                    <td style='text-align:center' width='25%'>দরপত্র সিডিউল বিক্রির শেষ তারিখ</td>
                    <td style='text-align:center' width='25%'>দরপত্র গ্রহণের তারিখ</td>
                    <td style='text-align:center' width='25%'>দরপত্র খোলার তারিখ</td>
                    <td style='text-align:center' width='25%'>সিদ্ধান্তের সম্ভাবা তারিখ</td>
                </tr>

                <tr>
                    <td style='text-align:center'>১</td>
                    <td style='text-align:center'>".int_en_to_bn(date('d/m/Y h:i', strtotime($row->form_buy_last_date)))."</td>
                    <td style='text-align:center'>".int_en_to_bn(date('d/m/Y h:i', strtotime($row->tender_start)))."</td>
                    <td style='text-align:center'>".int_en_to_bn(date('d/m/Y h:i', strtotime($row->tender_end)))."</td>
                    <td style='text-align:center'>".int_en_to_bn(date('d/m/Y h:i', strtotime($row->tender_open)))."</td>
                </tr>

             </table>




        ";

        return $nagoriinfo;
    }

    public function pdfHeader($row,$uniouninfo, $filename)
    {




        $pdfHead = '



        ';
        $output = '
          ' . $pdfHead . '
              <table width="100%" style="border-collapse: collapse;" border="0">
                  <tr>
                      <td style="text-align: center;" width="20%">
					  <span style="color:#b400ff;"><b>
					  উন্নয়নের গণতন্ত্র,  <br /> শেখ হাসিনার মূলমন্ত্র </b>

					  </span>
                      </td>
                      <td style="text-align: center;" width="20%">
                          <img width="70px" src="' . base64('backend/bd-logo.png') . '">
                      </td>
                      <td style="text-align: center;" width="20%">';
        $output .= '</td>
                  </tr>
                  <tr style="margin-top:2px;margin-bottom:2px;">
                      <td>
                      </td>
                      <td style="text-align: center;" width="50%">
                          <p style="font-size:20px">গণপ্রজাতন্ত্রী বাংলাদেশ</p>
                          <p style="font-size:25px">চেয়ারম্যানের কার্যালয়</p>

                      </td>
                      <td>
                      </td>
                  </tr>
                  <tr style="margin-top:0px;margin-bottom:0px;">
                      <td>
                      </td>
                      <td style="margin-top:0px; margin-bottom:0px; text-align: center;" width=50%>
                          <h1 style="color: #7230A0; margin: 0px; font-size: 28px">' . $uniouninfo->full_name . '</h3>
                      </td>
                      <td>
                      </td>
                  </tr>
                  <tr style="margin-top:2px;margin-bottom:2px;">
                      <td>
                      </td>
                      <td style="text-align: center; " width="50%">

                          <p style="font-size:20px">উপজেলা: ' . $uniouninfo->thana . ', জেলা: ' . $uniouninfo->district . ' ।</p>
                      </td>
                      <td>
                      </td>
                  </tr>
                  </table>';
        return $output;
    }
    public function pdfFooter($row,$uniouninfo, $filename)
    {




        $sonodNO = ' <div class="signature text-center position-relative">
        স্মারক নং: ' .  int_en_to_bn($row->memorial_no) . ' <br /> বিজ্ঞপ্তির তারিখ: '.int_en_to_bn(date("d/m/Y", strtotime($row->created_at))).'</div>';




$C_color = '#5c1caa';
$C_size = '20px';
$color = '#5c1caa';
$style = '';


            $ccc = '<img width="170px"  style="'.$style.'" src="' . base64($row->chaireman_sign) . '"><br/>
                              <b><span style="color:'.$C_color.';font-size:'.$C_size.';">' . $row->chaireman_name . '</span> <br />
                                      </b><span style="font-size:16px;">চেয়ারম্যান</span><br />';



         $qrurl = url("/pdf/tenders/$row->tender_id");

        // $qrurl = url("/verification/sonod/$row->id");
        //in Controller
        $qrcode = \QrCode::size(70)
            ->format('svg')
            ->generate($qrurl);
        $output = '
        <table width="100%" style="border-collapse: collapse;" border="0">
                              <tr>
                                  <td  style="text-align: center;" width="40%">
                             <div class="signature text-center position-relative">
                                      ' . $qrcode . '<br/>
                                       ' . $sonodNO . '
                                    </div>
                                  </td>
                                  <td style="text-align: center; width: 200px;" width="30%">
                                      <img width="100px" src="' . base64($uniouninfo->sonod_logo) . '">
                                  </td>
                                  <td style="text-align: center;" width="40%">
                                      <div class="signature text-center position-relative" style="color:'.$color.'">

                                      ' . $ccc . $uniouninfo->full_name . ' <br> ' . $uniouninfo->thana . ', ' . $uniouninfo->district . ' ।
                                      <br/>
                                      '. $row->c_email.'

                                      </div>
                                  </td>
                              </tr>
                          </table>
                            <p style="background: #787878;
            color: white;
            text-align: center;
            padding: 2px 2px;font-size: 16px;     margin-top: 0px;" class="m-0">"সময়মত ইউনিয়ন কর পরিশোধ করুন। ইউনিয়নের উন্নয়নমূক কাজে সহায়তা করুন"</p>
                            <p class="m-0" style="font-size:14px;text-align:center">বিজ্ঞপ্তিটি যাচাই করতে QR কোড স্ক্যান করুন</p>
                      </div>
                  </div>
              </div>';
        $output = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $output);
        return $output;
    }




    function SeletionTender(Request $request,$tender_id){



    $tender_list =  TenderList::find($tender_id);




    $currentDate = strtotime(date("d-m-Y H:i:s"));
    $tender_open = strtotime(date("d-m-Y H:i:s",strtotime($tender_list->tender_open)));
    if($currentDate<$tender_open){
        $result =  [
            "messages"=>"tender Open date : $tender_list->tender_open",
            "status"=>422,
        ];
        return response()->json([$result],422);
    }


    $tendersCount = Tender::where(['tender_id'=>$tender_id])->orderBy('DorAmount','desc')->count();
    if($tendersCount<1){
       $result =  [
           "messages"=>"Cant find Tender",
           "status"=>404,
       ];
       return response()->json([$result],404);
    }
    $tendersDorAmount = Tender::where(['tender_id'=>$tender_id])->orderBy('DorAmount','desc')->first()->DorAmount;
    $tenders = Tender::where(['DorAmount'=>$tendersDorAmount])->orderBy('DorAmount','desc')->get();

    foreach ($tenders as $value) {
        $value->update(['status'=>'Selected']);
    }
    $tender_list->update(['status'=>'Completed']);
    $result =  [
        "data"=>$tenders,
        "messages"=>"found Tender",
        "status"=>200,
    ];
    return response()->json([$result],200);




    }


    function PaymentCreate($id) {


        $tenderform = TenderFormBuy::find($id);

        $sonodFees =  TenderList::find($tenderform->tender_id);
        $sonod_fee =  $sonodFees->form_price;
        $unioun_name =  $sonodFees->union_name;
        $unioninfos = Uniouninfo::where(['short_name_e' => $unioun_name])->first();
        $u_code = $unioninfos->u_code;






        $totalamount = $sonod_fee;
        $applicant_mobile = $tenderform->PhoneNumber;
        $total_amount = $totalamount;
        $amount = 0;
        if ($total_amount == null || $total_amount == '' || $total_amount < 1) {
            $amount = 1;
        } else {
            $amount = $total_amount;
        }
        $trnx_id = $u_code.'-'.time();
        $cust_info = [
            "cust_email" => "",
            "cust_id" => "$id",
            "cust_mail_addr" => "Address",
            "cust_mobo_no" => "$applicant_mobile",
            "cust_name" => "Customer Name"
        ];
        $trns_info = [
            "ord_det" => 'sonod',
            "ord_id" => "$id",
            "trnx_amt" => $amount,
            "trnx_currency" => "BDT",
            "trnx_id" => "$trnx_id"
        ];
        // return $sonod->unioun_name;


            $redirectutl = ekpayToken($trnx_id, $trns_info, $cust_info,'payment',$unioun_name);



        $req_timestamp = date('Y-m-d H:i:s');

        $customerData = [
            'union' => $unioun_name,
            'trxId' => $trnx_id,
            'sonodId' => $id,
            'sonod_type' => 'Tenders_form',
            'amount' => $amount,
            'mob' => $applicant_mobile,
            'status' => "Pending",
            'paymentUrl' => $redirectutl,
            'method' => 'ekpay',
            'payment_type' => 'online',
            'date' => date('Y-m-d'),
            'created_at' => $req_timestamp,
        ];
        Payment::create($customerData);





        return redirect($redirectutl);

    }



}
