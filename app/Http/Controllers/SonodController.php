<?php
namespace App\Http\Controllers;
use Exception;
use App\Models\User;
use App\Models\Sonod;
use App\Models\Charage;
use App\Models\Citizen;
use App\Models\Payment;
use App\Models\SonodFee;
use App\Models\ActionLog;
use App\Models\Uniouninfo;
use App\Models\Expenditure;
use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Models\Sonodnamelist;
use Illuminate\Support\Facades\DB;
use App\Models\TradeLicenseKhatFee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Validator;
use Rakibhstu\Banglanumber\NumberToBangla;
// use Meneses\LaravelMpdf\Facades\LaravelMpdf;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class SonodController extends Controller
{
    public function prottonupdate(Request $request, $id)
    {
        $sonod = Sonod::find($id);
        $sonod->update(['sec_prottoyon' => $request->sec_prottoyon]);
    }
    public function sonodpaymentSuccessView(Request $request, $id)
    {


        $sonod = Sonod::find($id);
        return view('sonodsuccess', compact('sonod'));


    }
    public function sonodpaymentSuccess(Request $request)
    {
        $transId =  $request->transId;
         $payment = Payment::where(['trxId' => $transId])->first();
        $id = $payment->sonodId;
        $sonod = Sonod::find($id);
        $unioun_name =  $sonod->unioun_name;
        $sonod_name =  $sonod->sonod_name;
        $uniouninfo = Uniouninfo::where(['short_name_e' => $unioun_name])->first();
        // $sonodnamelists = Sonodnamelist::where(['bnname' => $sonod_name])->first();
        $payment_type = $uniouninfo->payment_type;
        if ($payment_type == 'Prepaid') {


            // $payment->update(['status' => 'Paid']);
            // $sonod->update(['stutus' => 'Pending', 'payment_status' => 'Paid']);

            // $sonod_name = sonodEnName($sonod->sonod_name);

if($payment->status=='Paid'){
            $InvoiceUrl =  url("/invoice/c/$id");
            // $deccription = "অভিনন্দন! আপনার আবেদনটি সফলভাবে পরিশোধিত হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন।";
            $deccription = "Congratulation! Your application $sonod->sonod_Id has been Paid.Wait for Approval.";
            // smsSend($deccription, $sonod->applicant_mobile);
            return view('applicationSuccess', compact('payment', 'sonod'));
}else{
    echo "
    <div style='text-align:center'>
    <h1 style='text-align:center'>Payment Failed</h1>
    <a href='/' style='border:1px solid black;padding:10px 12px; background:red;color:white'>Back To Home</a>
    <a href='/sonod/payment/$sonod->id' style='border:1px solid black;padding:10px 12px; background:green;color:white'>Pay Again</a>
    </div>
    ";
}


            // return redirect("/document/$sonod->sonod_name/$id");
            // echo "<script>window.close();</script>";


        } elseif ($payment_type == 'Postpaid') {
            $payment->update(['status' => 'Paid']);
            $sonod->update(['payment_status' => 'Paid']);
            // $sonod_name = sonodEnName($sonod->sonod_name);
            $sonodUrl =  url("/sonod/d/$id");
            $InvoiceUrl =  url("/invoice/d/$id");
            // $deccription = "অভিনন্দন! আপনার আবেদনটি সফলভাবে পরিশোধিত হয়েছে। সনদ : $sonodUrl রশিদ : $InvoiceUrl";
            $deccription = "Congratulation! Your application $sonod->sonod_Id has been Paid. Sonod : " . $sonodUrl . " Invoice : " . $InvoiceUrl;
            // smsSend($deccription, $sonod->applicant_mobile);
            return redirect("/sonod/payment/success/$id");
            echo '
    <style>
      body {
        text-align: center;
        padding: 40px 0;
        background: #EBF0F5;
      }
        h1 {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          margin-bottom: 10px;
        }
        p {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      i {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }
      .card {
        background: white;
        padding: 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
      }
      .buttons{
        color: white;
        text-decoration: none;
        padding: 8px 14px;
        border-radius: 7px;
        margin: 20px 8px;
      }
      .buttons.d{
        background: #0b4fb6;
      }
      .buttons.r{
        background: #8d2407;
      }
      .buttons.h{
        background: #380bb6;
      }
    </style>
      <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark">✓</i>
      </div>
        <h1>ধন্যবাদ</h1>
        <p>আমারা আপনার পেমেন্ট গ্রহন করেছি!</p>
        <div style="display:flex">
            <a class="buttons d" href="">আপনার সনদটি ডাউনলোড করুন</a>
            <a class="buttons r" href="">আপনার রশিদটি ডাউনলোড করুন</a>
            </div>
            <a class="buttons h" href="">মুল পেজএ ফিরে যান</a>
      </div>
            ';
        }
    }
    public function sonodpayment(Request $request, $id)
    {
        //  $unioun_name =  $r->unioun_name;
        $sonod = Sonod::find($id);

       $applicant_mobile =  int_bn_to_en($sonod->applicant_mobile);

        $unioun_name =  $sonod->unioun_name;
        $sonod_name =  $sonod->sonod_name;
        $uniouninfo = Uniouninfo::where(['short_name_e' => $unioun_name])->first();
        $sonodnamelists = Sonodnamelist::where(['bnname' => $sonod_name])->first();
        $payment_type = $uniouninfo->payment_type;
        if ($payment_type == 'Prepaid') {
            $sonodFees =  SonodFee::where(['service_id'=> $sonodnamelists->service_id,'unioun'=> $unioun_name])->first();
            $sonod_fee =  $sonodFees->fees;
            $unioninfos = Uniouninfo::where(['short_name_e' => $unioun_name])->first();
            $district = $unioninfos->district;
            $thana = $unioninfos->thana;
            $u_code = $unioninfos->u_code;
            $CharageCount = Charage::where(['district' => $district, 'thana' => $thana])->count();
            $vat = 0;
            $tax = 0;
            $service = 0;
            if ($CharageCount > 0) {
                $charge =   Charage::where(['district' => $district, 'thana' => $thana])->first();
                $vat = $charge->vat;
                $tax = $charge->tax;
                $service = $charge->service;
            }

            $tradeVat = 15;

            // $vatAmount = (($sonod_fee * $vat) / 100);
            // $taxAmount = (($sonod_fee * $tax) / 100);
            // $totalamount = $sonod_fee + $vatAmount + $taxAmount + $service;






            if($sonod_name=='ট্রেড লাইসেন্স'){

                $khat_id_1 = $sonod->applicant_type_of_businessKhat;
                $khat_id_2 = $sonod->applicant_type_of_businessKhatAmount;
                $pesaKorFee =  TradeLicenseKhatFee::where(['khat_id_1'=>$khat_id_1,'khat_id_2'=>$khat_id_2])->first();





                $TradevatAmount = (($sonod_fee * $tradeVat) / 100);
                $totalamount =$pesaKorFee->fee + $sonod_fee + $TradevatAmount;
            }else{
                $totalamount = $sonod_fee;
            }


            if ($totalamount == null || $totalamount == '' || $totalamount < 1) {
                $totalamount = 1;
            }




            // return $totalamount;

            // $arraydata = [
            //     'total_amount' => $totalamount,
            //     'pesaKor' => $request->pesaKor,
            //     'tredeLisenceFee' => $request->tredeLisenceFee,
            //     'vatAykor' => $request->vatAykor,
            //     'khat' => $request->khat,
            //     'last_years_money' => 0,
            //     'currently_paid_money' => $totalamount,
            // ];
            // $amount_deails = json_encode($arraydata);
            // $numto = new NumberToBangla();
            // $the_amount_of_money_in_words = $numto->bnMoney($totalamount) . ' মাত্র';
            // $updateData = [
            //     'khat' => $request->khat,
            //     'last_years_money' => 0,
            //     'currently_paid_money' => $totalamount,
            //     'total_amount' => $totalamount,
            //     'amount_deails' => $amount_deails,
            //     'the_amount_of_money_in_words' => $the_amount_of_money_in_words,
            // ];
            // $sonod->update($updateData);



            $total_amount = $sonod->total_amount;
            $amount = 0;
            if ($total_amount == null || $total_amount == '' || $total_amount < 1) {
                $amount = 1;
            } else {
                $amount = $total_amount;
            }
            $trnx_id = $u_code.'-'.time();
            $cust_info = [
                "cust_email" => "",
                "cust_id" => "$sonod->id",
                "cust_mail_addr" => "Address",
                "cust_mobo_no" => "$applicant_mobile",
                "cust_name" => "Customer Name"
            ];
            $trns_info = [
                "ord_det" => 'sonod',
                "ord_id" => "$sonod->sonod_Id",
                "trnx_amt" => $amount,
                "trnx_currency" => "BDT",
                "trnx_id" => "$trnx_id"
            ];
            // return $sonod->unioun_name;
            $redirectutl = ekpayToken($trnx_id, $trns_info, $cust_info,'payment',$sonod->unioun_name);

            $req_timestamp = date('Y-m-d H:i:s');
            $customerData = [
                'union' => $sonod->unioun_name,
                'trxId' => $trnx_id,
                'sonodId' => $id,
                'sonod_type' => $sonod->sonod_name,
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
        } elseif ($payment_type == 'Postpaid') {
            $stutus = $sonod->stutus;
            $payment_status = $sonod->payment_status;
            if ($stutus != 'approved') {
                return "আপনার অনুসন্ধানকৃত সনদ/প্রত্যয়নপত্র অত্র ইউনিয়ন পরিষদ থেকে এখনও অনুমোদন করা হয়নি।";
            }
            if ($payment_status != 'Unpaid' && $stutus == 'approved') {
                return redirect("/sonod/$sonod->sonod_name/$id");
            }
            $total_amount = $sonod->total_amount;
            $amount = 0;
            if ($total_amount == null || $total_amount < 10) {
                $amount = 10;
            } else {
                $amount = $total_amount;
            }
            $trnx_id = time();
            $cust_info = [
                "cust_email" => "",
                "cust_id" => "$sonod->sonod_Id",
                "cust_mail_addr" => "Address",
                "cust_mobo_no" => "$applicant_mobile",
                "cust_name" => "Customer Name"
            ];
            $req_timestamp = date('Y-m-d H:i:s');
            $customerData = [
                'union' => $sonod->unioun_name,
                'trxId' => $trnx_id,
                'sonodId' => $id,
                'sonod_type' => $sonod->sonod_name,
                'amount' => $amount,
                'mob' => $applicant_mobile,
                'status' => "Pending",
                'date' => date('Y-m-d'),
                'created_at' => $req_timestamp,
            ];
            Payment::create($customerData);
            $redirectutl =  ekpayToken($trnx_id, $amount, $cust_info,'payment',$sonod->unioun_name);
            return redirect($redirectutl);
        }
    }
    public function akpay(Request $request)
    {
        $trnx_id = time();
        $cust_info = [
            "cust_email" => "",
            "cust_id" => "1",
            "cust_mail_addr" => "Address",
            "cust_mobo_no" => "01909756552",
            "cust_name" => "Customer Name"
        ];
        $redirectutl =  ekpayToken($trnx_id, 10, $cust_info);
        return redirect($redirectutl);
    }
    public function sonod_id(Request $request)
    {
        $sonodFinalId = '';
        $sortYear =  date('y');
        $union =  $request->union;
        $UniouninfoCount =   Uniouninfo::where('short_name_e', $union)->latest()->count();
        $SonodCount =   Sonod::where(['unioun_name' => $union, 'year' => date('Y')])->latest()->count();
        if ($UniouninfoCount > 0) {
            $Uniouninfo =   Uniouninfo::where('short_name_e', $union)->latest()->first();
            if ($SonodCount > 0) {
                $Sonod =  Sonod::where(['unioun_name' => $union, 'year' => date('Y')])->latest()->first();
                if ($Sonod->sonod_Id == '') {
                    $sonod_Id = str_pad(00001, 5, '0', STR_PAD_LEFT);
                    $sonodFinalId =  $Uniouninfo->u_code . $sortYear . $sonod_Id;
                } else {
                    // $sonod_Id = $Sonod->Sonod+1;
                    $sonod_Id = str_pad($Sonod->sonod_Id, 5, '0', STR_PAD_LEFT);
                    // $sonodFinalId =  $Uniouninfo->u_code.$sortYear.$sonod_Id;
                    $sonodFinalId = $Sonod->sonod_Id + 1;
                }
            } else {
                $sonod_Id = str_pad(00001, 5, '0', STR_PAD_LEFT);
                $sonodFinalId =  $Uniouninfo->u_code . $sortYear . $sonod_Id;
            }
        };
        return $sonodFinalId;
    }
    function allsonodId($union, $sonodname)
    {
        $sonodFinalId = '';
        $sortYear =  date('y')-1;
        $UniouninfoCount =   Uniouninfo::where('short_name_e', $union)->latest()->count();
        $SonodCount =   Sonod::where(['unioun_name' => $union, 'sonod_name' => $sonodname])->latest()->count();
        if ($UniouninfoCount > 0) {
            $Uniouninfo =   Uniouninfo::where('short_name_e', $union)->latest()->first();
            if ($SonodCount > 0) {
                $Sonod =  Sonod::where(['unioun_name' => $union, 'sonod_name' => $sonodname])->latest()->first();
                // $sonodFinalId = 'fgdfgdfg';
                $sonodFinalId = $Sonod->sonod_Id + 1;
                // if ($Sonod->sonod_Id == '') {
                //     $sonod_Id = str_pad(00001, 5, '0', STR_PAD_LEFT);
                //     $sonodFinalId =  $Uniouninfo->u_code . $sortYear . $sonod_Id;
                // } else {
                //     // $sonod_Id = $Sonod->Sonod+1;
                //     $sonod_Id = str_pad($Sonod->sonod_Id, 5, '0', STR_PAD_LEFT);
                //     // $sonodFinalId =  $Uniouninfo->u_code.$sortYear.$sonod_Id;
                //     $sonodFinalId = $Sonod->sonod_Id + 1;
                // }
            } else {
                $sonod_Id = str_pad(00001, 5, '0', STR_PAD_LEFT);
                $sonodFinalId =  $Uniouninfo->u_code . $sortYear . $sonod_Id;
            }
        };
        return $sonodFinalId;
    }



    public function sonod_update(Request $r)
    {



        $id = $r->id;
        $stutus = $r->stutus;
        // if($id){
        //     return Sonod::find($id);
        // }
        //  $unioun_name =  $r->unioun_name;
        // $uniouninfo = Uniouninfo::where(['short_name_e'=>$unioun_name])->first();
        // $payment_type = $uniouninfo->payment_type;
        $successors = json_encode($r->successors);
        $sonodEnName =  Sonodnamelist::where('bnname', $r->sonod_name)->first();
        $filepath =  str_replace(' ', '_', $sonodEnName->enname);
        $Insertdata = [];
        $Insertdata = $r->except(['sonod_Id', 'image', 'applicant_national_id_front_attachment', 'applicant_national_id_back_attachment', 'applicant_birth_certificate_attachment', 'successors']);
        $imageCount =  count(explode(';', $r->image));
        $national_id_frontCount =  count(explode(';', $r->applicant_national_id_front_attachment));
        $national_id_backCount =  count(explode(';', $r->applicant_national_id_back_attachment));
        $birth_certificateCount =  count(explode(';', $r->applicant_birth_certificate_attachment));
        if ($imageCount > 1) {
            $Insertdata['image'] =  fileupload($r->image, "sonod/$filepath/image/", 250, 300);
        }
        if ($national_id_frontCount > 1) {
            $Insertdata['applicant_national_id_front_attachment'] =  fileupload($r->applicant_national_id_front_attachment, "sonod/$filepath/applicant_national_id_front_attachment/");
        }
        if ($national_id_backCount > 1) {
            $Insertdata['applicant_national_id_back_attachment'] =  fileupload($r->applicant_national_id_back_attachment, "sonod/$filepath/applicant_national_id_back_attachment/");
        }
        if ($birth_certificateCount > 1) {
            $Insertdata['applicant_birth_certificate_attachment'] =  fileupload($r->applicant_birth_certificate_attachment, "sonod/$filepath/applicant_birth_certificate_attachment/");
        }
        // $Insertdata['sonod_Id'] = $successors;
        $Insertdata['successor_list'] = $successors;
        $Uniouninfo =   Uniouninfo::where('short_name_e', $r->unioun_name)->latest()->first();
        // $Insertdata['chaireman_name'] = $Uniouninfo->c_name;
        // $Insertdata['c_email'] = $Uniouninfo->c_email;
        // $Insertdata['chaireman_sign'] = $Uniouninfo->c_signture;
        try {
            $unioun_name = $r->unioun_name;
            $sonod_name = $r->sonod_name;
            // return  $this->allsonodId($unioun_name, $sonod_name);
            // $Insertdata['sonod_Id'] = (string)$this->allsonodId($unioun_name, $sonod_name);
            //    $oldsonod =  Sonod::where(['unioun_name' => $unioun_name,'sonod_name' => $sonod_name, 'year' => date('Y')])->latest()->first();
            // $oldsonodNo = (int)$oldsonod->sonod_Id;
            //  $Insertdata['sonod_Id'] =  $oldsonodNo+1;
             $sonod =   Sonod::find($id);
           return  $sonod->update($Insertdata);

            // return  $sonod;
        } catch (Exception $e) {
            return sent_error($e->getMessage(), $e->getCode());
        }
    }



    public function sonod_submit(Request $r)
    {

        // return $r->all();
// return $r->charages['totalamount'];

        $id = $r->id;
        $stutus = $r->stutus;
        // if($id){
        //     return Sonod::find($id);
        // }
        //  $unioun_name =  $r->unioun_name;
        // $uniouninfo = Uniouninfo::where(['short_name_e'=>$unioun_name])->first();
        // $payment_type = $uniouninfo->payment_type;
        $successors = json_encode($r->successors);
        $sonodEnName =  Sonodnamelist::where('bnname', $r->sonod_name)->first();
        $filepath =  str_replace(' ', '_', $sonodEnName->enname);
        $Insertdata = [];
        $Insertdata = $r->except(['sonod_Id', 'image', 'applicant_national_id_front_attachment', 'applicant_national_id_back_attachment', 'applicant_birth_certificate_attachment', 'successors', 'charages']);
        $imageCount =  count(explode(';', $r->image));
        $national_id_frontCount =  count(explode(';', $r->applicant_national_id_front_attachment));
        $national_id_backCount =  count(explode(';', $r->applicant_national_id_back_attachment));
        $birth_certificateCount =  count(explode(';', $r->applicant_birth_certificate_attachment));
        if ($imageCount > 1) {
            $Insertdata['image'] =  fileupload($r->image, "sonod/$filepath/image/", 250, 300);
        }
        if ($national_id_frontCount > 1) {
            $Insertdata['applicant_national_id_front_attachment'] =  fileupload($r->applicant_national_id_front_attachment, "sonod/$filepath/applicant_national_id_front_attachment/");
        }
        if ($national_id_backCount > 1) {
            $Insertdata['applicant_national_id_back_attachment'] =  fileupload($r->applicant_national_id_back_attachment, "sonod/$filepath/applicant_national_id_back_attachment/");
        }
        if ($birth_certificateCount > 1) {
            $Insertdata['applicant_birth_certificate_attachment'] =  fileupload($r->applicant_birth_certificate_attachment, "sonod/$filepath/applicant_birth_certificate_attachment/");
        }
        // $Insertdata['sonod_Id'] = $successors;
        $Insertdata['successor_list'] = $successors;
        $Uniouninfo =   Uniouninfo::where('short_name_e', $r->unioun_name)->latest()->first();
        $Insertdata['chaireman_name'] = $Uniouninfo->c_name;
        $Insertdata['c_email'] = $Uniouninfo->c_email;
        $Insertdata['chaireman_sign'] = $Uniouninfo->c_signture;
        try {
            $unioun_name = $r->unioun_name;
            $sonod_name = $r->sonod_name;
            // return  $this->allsonodId($unioun_name, $sonod_name);
            $Insertdata['sonod_Id'] = (string)$this->allsonodId($unioun_name, $sonod_name);
            //    $oldsonod =  Sonod::where(['unioun_name' => $unioun_name,'sonod_name' => $sonod_name, 'year' => date('Y')])->latest()->first();
            // $oldsonodNo = (int)$oldsonod->sonod_Id;
            //  $Insertdata['sonod_Id'] =  $oldsonodNo+1;



            $stutus = $r->stutus;
            if($stutus=='Prepaid'){

                $totalamount = $r->charages['totalamount'];
                $sonod_fee = $r->charages['sonod_fee'];
                $tradeVat = $r->charages['tradeVat'];
                $pesaKor = $r->charages['pesaKor'];

                $arraydata = [
                'total_amount' => $totalamount,
                'pesaKor' => $pesaKor,
                'tredeLisenceFee' => $sonod_fee,
                'vatAykor' => $tradeVat,
                'khat' => '',
                'last_years_money' => 0,
                'currently_paid_money' => $totalamount,
                ];
                $amount_deails = json_encode($arraydata);
                $numto = new NumberToBangla();
                $the_amount_of_money_in_words = $numto->bnMoney($totalamount) . ' মাত্র';

                $Insertdata['khat'] = '';
                $Insertdata['last_years_money'] = 0;
                $Insertdata['currently_paid_money'] = $totalamount;
                $Insertdata['total_amount'] = $totalamount;
                $Insertdata['the_amount_of_money_in_words'] = $the_amount_of_money_in_words;
                $Insertdata['amount_deails'] = $amount_deails;


            }



// return $Insertdata;



             $sonod =   sonod::create($Insertdata);
            if ($stutus == 'Pending') {
                $deccription = "Congratulation! Your application $sonod->sonod_Id has been Submited.Wait for Approval";
                // smsSend($deccription, $sonod->applicant_mobile);
            }

            $notifiData = ['union'=>$sonod->unioun_name,'roles'=>'Secretary'];
            $notificationsCount = Notifications::where($notifiData)->count();
            if($notificationsCount>0){
               $action =   makeshorturl(url('/secretary/approve/'.$sonod->id));
               $notifications = Notifications::where($notifiData)->latest()->first();
               $data =' {"to":"'.$notifications->key.'","notification":{"body":"'.$sonod->applicant_name.' একটি '.$sonod->sonod_name.' এর নুতুন আবেদন করেছে","title":"সনদ নং '.int_en_to_bn($sonod->sonod_Id).'","icon":"'.asset('assets/img/bangladesh-govt.png').'","click_action":"'.$action.'"}}';
                pushNotification($data);
            }

            // $details = [
            //     "title" => "একটি নতুন আবেদন দাখিল হয়েছে",
            //     "body" => "$sonod->applicant_name একটি $sonod->sonod_name এর নুতুন আবেদন করেছে। সনদ নং ".int_en_to_bn($sonod->sonod_Id),
            //     "click_action"=> url('/secretary/approve/'.$sonod->id)
            // ];
            // $subject = 'hello subject';
            // \Mail::to('freelancernishad123@gmail.com')->send(new \App\Mail\MyTestMail($details,$subject));






            return  $sonod;
        } catch (Exception $e) {
            return sent_error($e->getMessage(), $e->getCode());
        }
    }




    public function sonod_delete($id)
    {
        $sonod =  Sonod::find($id);
        $sonod->delete();
        return 'Sonod deleted!';
    }
    public function sec_sonod_action(Request $request, $id)
    {

        $sonod = Sonod::find($id);

        $sec_prottoyon = $request->sec_prottoyon;
        // return $request->all();
        $arraydata = [
            'total_amount' => $request->amounta,
            'pesaKor' => $request->pesaKor,
            'tredeLisenceFee' => $request->tredeLisenceFee,
            'vatAykor' => $request->vatAykor,
            'khat' => $request->khat,
            'last_years_money' => $request->last_years_money,
            'currently_paid_money' => $request->currently_paid_money,
        ];
        $amount_deails = json_encode($arraydata);
        $numto = new NumberToBangla();
        $the_amount_of_money_in_words = $numto->bnMoney($request->amounta) . ' মাত্র';
        if ($sec_prottoyon) {
             $approveData = $request->approeDatav;

            if($approveData =='null_approved'){
                $approveData = 'Secretary_approved';
            }else{
                $approveData = 'Secretary_approved';
            }


            if($sonod->payment_status=='Paid'){
                $updateData = [
                    'sec_prottoyon' => $sec_prottoyon,
                    'stutus' => $approveData,
                ];
            }else{
                $updateData = [
                    'khat' => $request->khat,
                    'last_years_money' => $request->last_years_money,
                    'currently_paid_money' => $request->currently_paid_money,
                    'total_amount' => $request->amounta,
                    'the_amount_of_money_in_words' => $the_amount_of_money_in_words,
                    'khat' => $request->khat,
                    'amount_deails' => $amount_deails,
                    'sec_prottoyon' => $sec_prottoyon,
                    'stutus' => $approveData,
                ];
            }





            $notifiData = ['union'=>$sonod->unioun_name,'roles'=>'Chairman'];
            $notificationsCount = Notifications::where($notifiData)->count();
            if($notificationsCount>0){
               $notifications = Notifications::where($notifiData)->latest()->first();
               $data =' {"to":"'.$notifications->key.'","notification":{"body":"সচিব '.$sonod->applicant_name.' এর '.$sonod->sonod_name.' এর আবেদনটি অনুমোদন করেছে","title":"সনদ নং '.int_en_to_bn($sonod->sonod_Id).'","icon":"'.asset('assets/img/bangladesh-govt.png').'","click_action":"'.url('/chairman/approve/'.$sonod->id).'"}}';
               pushNotification($data);
            }







            // return $updateData;
            return $sonod->update($updateData);
        }


        $updateData = [
            'khat' => $request->khat,
            'last_years_money' => $request->last_years_money,
            'currently_paid_money' => $request->currently_paid_money,
            'total_amount' => $request->amounta,
            'amount_deails' => $amount_deails,
            'the_amount_of_money_in_words' => $the_amount_of_money_in_words,
            'stutus' => $request->approeDatav,
        ];

        $Uniouninfo =   Uniouninfo::where('short_name_e', $sonod->unioun_name)->latest()->first();
        $updateData['chaireman_name'] = $Uniouninfo->c_name;
        $updateData['c_email'] = $Uniouninfo->c_email;
        $updateData['chaireman_sign'] = $Uniouninfo->c_signture;




        return $sonod->update($updateData);
    }
    public function sonod_pay(Request $request, $id)
    {
        $type = $request->type;
        // return $request->all();
        $sonod = Sonod::find($id);
        $sonodUrl =  url("/sonod/d/$id");
        $InvoiceUrl =  url("/invoice/d/$id");
        $deccription = "Congratulation! Your application $sonod->sonod_Id  has been Paid. Sonod : " . $sonodUrl . " Invoice : " . $InvoiceUrl;
        // $deccription = "অভিনন্দন! আপনার আবেদনটি সফলভাবে পরিশোধিত হয়েছে। সনদ : $sonodUrl রশিদ : $InvoiceUrl";
        // smsSend($deccription, $sonod->applicant_mobile);
        $req_timestamp = date('Y-m-d H:i:s');


    //     $monthName = date('F');
    //     $expenditure = Expenditure::where(['month'=>$monthName])->latest()->first();
    //    $buyBalance = $expenditure->balance+$sonod->total_amount;
    //     $expenditure->update(['balance'=>$buyBalance]);


        $customerData = [
            'union' => $sonod->unioun_name,
            'trxId' => time(),
            'sonodId' => $id,
            'sonod_type' => $sonod->sonod_name,
            'amount' => $sonod->total_amount,
            'mob' => $sonod->applicant_mobile,
            'status' => "Paid",
            'date' => date('Y-m-d'),
            'month' => date('F'),
            'year' => date('Y'),
            'balance' =>0,
            'created_at' => $req_timestamp,
        ];
        Payment::create($customerData);





        if($type=='notify'){

             $sonod->update(['payment_status' => 'Paid']);
            return Sonod::find($id);
        }else{

            return $sonod->update(['payment_status' => 'Paid']);
        }





    }
    public function cancelsonod(Request $request, $id)
    {
        $sonod = Sonod::find($id);
        $data = $request->all();
        ActionLog::create($data);
        $sonod->update(['cancedby' => $request->names, 'cancedbyUserid' => $request->user_id]);
        $InvoiceUrl =  url("/reject/$id");
        $deccription = "Opps! Your application $sonod->sonod_Id  has been Not Approve. Details : " . $InvoiceUrl;
        // smsSend($deccription, $sonod->applicant_mobile);
        $updatedata = [
            'stutus' => $request->status,
        ];
        return $sonod->update($updatedata);
    }
    public function sonod_action(Request $request, $action, $id)
    {
        $sonod = Sonod::find($id);
        $type = $request->type;
        $unioun_name = $sonod->unioun_name;
        $uniouninfos = Uniouninfo::where(['short_name_e' => $unioun_name])->first();
        if ($action == 'approved') {
            $updatedata = [
                'chaireman_name' => $uniouninfos->c_name,
                'c_email' => $uniouninfos->c_email,
                'chaireman_sign' => $uniouninfos->c_signture,
                'stutus' => $action,
            ];
            $sonod_name =  sonodEnName($sonod->sonod_name);
            $payment_type = $uniouninfos->payment_type;
            if ($payment_type == 'Prepaid') {
                $sonodUrl =  url("/sonod/d/$id");
                $InvoiceUrl =  url("/invoice/d/$id");
                // $deccription = "Congratulation! Your application $sonod->sonod_Id  has been Approved. Sonod : " . $sonodUrl;
                $deccription = "Congratulation! Your application $sonod->sonod_Id has been approved. Document is available at  $sonodUrl";
                // $deccription = "অভিনন্দন! আপনার আবেদনটি সফলভাবে অনুমোদিত হয়েছে। সনদ : $sonodUrl রশিদ : $InvoiceUrl";
                // smsSend($deccription, $sonod->applicant_mobile);
                SmsNocSmsSend($deccription, $sonod->applicant_mobile);

            } elseif ($payment_type == 'Postpaid') {
                $paymentUrl =  url("/sonod/payment/$id");
                $deccription = "Congratulation! Your application $sonod->sonod_Id  has been Approved. Pay: " . $paymentUrl;
                // $deccription = "অভিনন্দন! আপনার আবেদনটি সফলভাবে অনুমোদিত হয়েছে। আবেদনের ফি প্রদানের জন্য ক্লিক করুন " . $paymentUrl;
            }









        } else {
            $updatedata = [
                'stutus' => $action,
            ];
        }



        $notifiData = ['union'=>$sonod->unioun_name,'roles'=>'Secretary'];
        $notificationsCount = Notifications::where($notifiData)->count();
        if($notificationsCount>0){
           $notifications = Notifications::where($notifiData)->latest()->first();
           $data =' {"to":"'.$notifications->key.'","notification":{"body":"চেয়ারম্যান '.$sonod->applicant_name.' এর '.$sonod->sonod_name.' এর আবেদনটি অনুমোদন করেছে","title":"সনদ নং '.int_en_to_bn($sonod->sonod_Id).'","icon":"'.asset('assets/img/bangladesh-govt.png').'","click_action":"'.url('/secretary/pay/'.$sonod->id).'"}}';
           pushNotification($data);
        }


        // return $type;
        if($type=='notify'){

             $sonod->update($updatedata);
             return redirect('/dashboard');
            }
            return $sonod->update($updatedata);
    }

    public function ChairnamNotificationApprove($id)
    {
        $redirecturl = "?redirect=".url('/chairman/approve/'.$id);

        if(!Auth::user()){
            return redirect('/login'.$redirecturl);
        }
     $user = Auth::user();

     $sonod= Sonod::find($id);
     $unioun = $user->unioun;
    if($unioun!=$sonod->unioun_name){
        $unionname = Uniouninfo::where('short_name_e',$sonod->unioun_name)->first();
           $unionname2 = Uniouninfo::where('short_name_e',$unioun)->first();
        return "আপনি $unionname->full_name এর তথ্য $unionname2->full_name থেকে অনুমোদন করতে পারবেন না";
    }
    $position = $user->position;
    if($position=='Secretary'){
        return "সচিব এই এড্রেসটি অ্যাক্সেস করতে পারবে না <a href='/dashboard/logout$redirecturl'>Logout</a>";
    }



        $enname= str_replace("_", " ",sonodEnName($sonod->sonod_name));

            $sonodnamedata =  Sonodnamelist::where('enname', $enname)->first();

        // return Sonodnamelist::all();


        $role = 'Chairman';
        $Secretary_pay = '';
        if($sonod->stutus=='Secretary_approved'){


            return view('chairemanapprove',compact('sonod','sonodnamedata','role','Secretary_pay'));

        }elseif($sonod->stutus=='approved'){
            if($sonod->payment_status=='Paid'){
                $Secretary_pay = 'Secretary_pay';
                return view('chairemanapprove',compact('sonod','sonodnamedata','role','Secretary_pay'));
            }
            return 'সনদটি ইতিমধ্যে চেয়ারম্যান কর্তৃক অনুমোদিত হয়েছে';
        }else{
            return 'সনদটি এখনো সচিব এর প্যানেল এ আছে';

        }

    }


    public function SecretariNotificationApprove($id)
    {

        $redirecturl = "?redirect=".url('/secretary/approve/'.$id);

        if(!Auth::user()){
            return redirect('/login'.$redirecturl);
        }
     $user = Auth::user();

     $sonod= Sonod::find($id);
     $unioun = $user->unioun;
    if($unioun!=$sonod->unioun_name){
        $unionname = Uniouninfo::where('short_name_e',$sonod->unioun_name)->first();
           $unionname2 = Uniouninfo::where('short_name_e',$unioun)->first();
        return "আপনি $unionname->full_name এর তথ্য $unionname2->full_name থেকে অনুমোদন করতে পারবেন না";
    }
    $position = $user->position;
    if($position=='Chairman'){
        return "চেয়ারম্যান এই এড্রেসটি অ্যাক্সেস করতে পারবে না <a href='/dashboard/logout$redirecturl'>Logout</a>";
    }



        $enname= str_replace("_", " ",sonodEnName($sonod->sonod_name));

            $sonodnamedata =  Sonodnamelist::where('enname', $enname)->first();

        // return Sonodnamelist::all();

        $role = 'Secretary';
        $Secretary_pay = '';

        if($sonod->stutus=='Pending'){


            return view('chairemanapprove',compact('sonod','sonodnamedata','role','Secretary_pay'));



        }elseif($sonod->stutus=='approved'){
            if($sonod->payment_status=='Paid'){
                $Secretary_pay = 'Secretary_pay';
                return view('chairemanapprove',compact('sonod','sonodnamedata','role','Secretary_pay'));
            }
            return 'সনদটি ইতিমধ্যে চেয়ারম্যান কর্তৃক অনুমোদিত হয়েছে';
        }else{
            return 'সনদটি চেয়ারম্যান এর প্যানেল এ আছে';

        }

    }




    public function SecretariNotificationPay($id)
    {

        $redirecturl = "?redirect=".url('/secretary/pay/'.$id);

        if(!Auth::user()){
            return redirect('/login'.$redirecturl);
        }
     $user = Auth::user();

     $sonod= Sonod::find($id);
     $unioun = $user->unioun;
    if($unioun!=$sonod->unioun_name){
        $unionname = Uniouninfo::where('short_name_e',$sonod->unioun_name)->first();
           $unionname2 = Uniouninfo::where('short_name_e',$unioun)->first();
        return "আপনি $unionname->full_name এর তথ্য $unionname2->full_name থেকে অনুমোদন করতে পারবেন না";
    }
    $position = $user->position;
    if($position=='Chairman'){
        return "চেয়ারম্যান এই এড্রেসটি অ্যাক্সেস করতে পারবে না <a href='/dashboard/logout$redirecturl'>Logout</a>";
    }



        $enname= str_replace("_", " ",sonodEnName($sonod->sonod_name));

            $sonodnamedata =  Sonodnamelist::where('enname', $enname)->first();

        // return Sonodnamelist::all();

        $role = 'Secretary';
        $Secretary_pay = 'Secretary_pay';

        if($sonod->stutus=='approved'){


            return view('chairemanapprove',compact('sonod','sonodnamedata','role','Secretary_pay'));



        }elseif($sonod->stutus=='approved'){
            return 'সনদটি ইতিমধ্যে চেয়ারম্যান কর্তৃক অনুমোদিত হয়েছে';
        }else{
            return 'সনদটি এখনো চেয়ারম্যান এর প্যানেল এ আছে';

        }

    }





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function enBnName($data)
    {
        $data =  str_replace("_", " ", $data);
        return Sonodnamelist::where('enname', $data)->first();
    }
    public function index(Request $request)
    {

        $sonod_name = $request->sonod_name;
        $stutus = $request->stutus;
        $payment_status = $request->payment_status;
        $unioun_name = $request->unioun_name;
        $sondId = $request->sondId;
        $sonod_name =  $this->enBnName($sonod_name)->bnname;
         $Sonodnamelist = Sonodnamelist::where('bnname', $sonod_name)->first();


        $userid = $request->userid;
        if($userid){
            $user = User::find($userid);
             $thana = $user->thana;

             if ($payment_status) {
                $sonods = Sonod::where(['sonod_name' => $sonod_name, 'stutus' => $stutus, 'applicant_present_Upazila' => $thana, 'payment_status' => $payment_status])->orderBy('id', 'DESC')->paginate(20);
                $returnData = [
                    'sonods'=>$sonods,
                    'sonod_name'=>$Sonodnamelist,
                ];
                return $returnData;

            }
            $sonods = Sonod::where(['sonod_name' => $sonod_name, 'stutus' => $stutus, 'applicant_present_Upazila' => $thana])->orderBy('id', 'DESC')->paginate(20);
            $returnData = [
                'sonods'=>$sonods,
                'sonod_name'=>$Sonodnamelist,
            ];
            return $returnData;

        }


        if ($sondId) {


            if($unioun_name){
                $sonods =  Sonod::where("sonod_Id", "LIKE", "%$sondId%")->where(['sonod_name' => $sonod_name, 'stutus' => $stutus, 'unioun_name' => $unioun_name])->orderBy('id', 'DESC')->paginate(20);
            }else{
                $sonods =  Sonod::where("sonod_Id", "LIKE", "%$sondId%")->where(['sonod_name' => $sonod_name, 'stutus' => $stutus])->orderBy('id', 'DESC')->paginate(20);
            }



            $returnData = [
                'sonods'=>$sonods,
                'sonod_name'=>$Sonodnamelist,
            ];
            return $returnData;
        }
        if ($unioun_name) {
            if ($payment_status) {
                $sonods =  Sonod::where(['sonod_name' => $sonod_name, 'stutus' => $stutus, 'unioun_name' => $unioun_name, 'payment_status' => $payment_status])->orderBy('id', 'DESC')->paginate(20);
                $returnData = [
                    'sonods'=>$sonods,
                    'sonod_name'=>$Sonodnamelist,
                ];
                return $returnData;
            }
            $sonods =  Sonod::where(['sonod_name' => $sonod_name, 'stutus' => $stutus, 'unioun_name' => $unioun_name])->orderBy('id', 'DESC')->paginate(20);
            $returnData = [
                'sonods'=>$sonods,
                'sonod_name'=>$Sonodnamelist,
            ];
            return $returnData;
        }
        $sonods = Sonod::where(['sonod_name' => $sonod_name, 'stutus' => $stutus])->orderBy('id', 'DESC')->paginate(20);
        $returnData = [
            'sonods'=>$sonods,
            'sonod_name'=>$Sonodnamelist,
        ];
        return $returnData;





        $datas = QueryBuilder::for(Sonod::class)
            ->allowedFilters([
                AllowedFilter::exact('unioun_name'),
                AllowedFilter::exact('sonod_Id'),
                AllowedFilter::exact('stutus'),
                AllowedFilter::exact('payment_status'),
                // AllowedFilter::exact('sonod_name'),
                'image',
                'successor_father_name',
                'successor_mother_name',
                'successor_father_alive_status',
                'successor_mother_alive_status',
                'applicant_holding_tax_number',
                'applicant_national_id_number',
                'applicant_birth_certificate_number',
                'applicant_passport_number',
                'applicant_date_of_birth',
                'applicant_owner_type',
                'applicant_name_of_the_organization',
                'applicant_name',
                'applicant_gender',
                'applicant_marriage_status',
                'applicant_vat_id_number',
                'applicant_tax_id_number',
                'applicant_type_of_business',
                'applicant_father_name',
                'applicant_mother_name',
                'applicant_occupation',
                'applicant_education',
                'applicant_religion',
                'applicant_resident_status',
                'applicant_present_village',
                'applicant_present_road_block_sector',
                'applicant_present_word_number',
                'applicant_present_district',
                'applicant_present_Upazila',
                'applicant_present_post_office',
                'applicant_permanent_village',
                'applicant_permanent_road_block_sector',
                'applicant_permanent_word_number',
                'applicant_permanent_district',
                'applicant_permanent_Upazila',
                'applicant_permanent_post_office',
                'successor_list',
                'khat',
                'last_years_money',
                'currently_paid_money',
                'total_amount',
                'amount_deails',
                'the_amount_of_money_in_words',
                'applicant_mobile',
                'applicant_email',
                'applicant_phone',
                'applicant_national_id_front_attachment',
                'applicant_national_id_back_attachment',
                'applicant_birth_certificate_attachment',
                'chaireman_name',
                'chaireman_sign', AllowedFilter::exact('id')
            ])
            ->orderBy('id', 'DESC');
        return $datas->where(['sonod_name' => $sonod_name])->paginate(20);
    }
    public function sonodDownload(Request $request, $name, $id)
    {


        ini_set('max_execution_time', '60000');
        ini_set("pcre.backtrack_limit", "5000000000000000050000000000000000");
        ini_set('memory_limit', '12008M');

       $row = Sonod::find($id);
        $sonod_name = $row->sonod_name;
        $sonod = Sonodnamelist::where('bnname', $row->sonod_name)->first();
        $uniouninfo = Uniouninfo::where('short_name_e', $row->unioun_name)->first();
        $sonodnames = Sonodnamelist::where(['bnname' => $row->sonod_name])->first();
        // return view('sonod',compact('row','sonod','uniouninfo'));
        $EnsonodName = str_replace(" ", "_", $sonodnames->enname);
        if ($sonod_name == 'ওয়ারিশান সনদ' || $sonod_name == 'উত্তরাধিকারী সনদ') {
            $filename = "$EnsonodName-$row->sonod_Id.pdf";
            // return $this->pdfHeader($id,$filename);
            // $pdf = LaravelMpdf::loadView('utsonod', compact('row', 'sonod', 'uniouninfo'));
            // return $pdf->stream("$EnsonodName-$row->sonod_Id.pdf");
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 12,
                'default_font' => 'bangla',
                'mode' => 'utf-8',
                'format' => 'A4',
                'setAutoTopMargin' => 'stretch',
                'setAutoBottomMargin' => 'stretch'
            ]);
            $mpdf->SetDisplayMode('fullpage');
            $mpdf->SetHTMLHeader($this->pdfHeader($id, $filename));
            $mpdf->SetHTMLFooter($this->pdfFooter($id, $filename));
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
            $mpdf->WriteHTML($this->pdfHTMLut($id, $filename));
            $mpdf->useSubstitutions = false;
            $mpdf->simpleTables = true;
            $mpdf->Output($filename, 'I');
        } else {



            // return view('sonod', compact('row', 'sonod', 'uniouninfo'));
            $pdf = LaravelMpdf::loadView('sonod', compact('row', 'sonod', 'uniouninfo','sonodnames'));
            return $pdf->stream("$EnsonodName-$row->sonod_Id.pdf");
        }
    }

    public function invoice(Request $request, $name, $id)
    {
        $row = Sonod::find($id);
        $row->unioun_name;
        $sonod = Sonodnamelist::where('bnname', $row->sonod_name)->first();
        $uniouninfo = Uniouninfo::where('short_name_e', $row->unioun_name)->first();
        $sonodnames = Sonodnamelist::where(['bnname' => $row->sonod_name])->first();
        $EnsonodName = str_replace(" ", "_", $sonodnames->enname);

$TaxInvoice = Payment::where('sonodId',$row->id)->latest()->first();

        if ($name == 'c') {
            $pdf = LaravelMpdf::loadView('cinvoice', compact('row', 'sonod', 'uniouninfo'));
            $pdf->stream("$EnsonodName-$row->sonod_Id.pdf");
        } else {


    //         $khatlist = $row->amount_deails;
    //         $khatlist = json_decode($khatlist);
    //         $total = $khatlist->tredeLisenceFee;
    //         $amount = ($total*$khatlist->vatAykor)/100;


    //         $totalAmount = $khatlist->pesaKor+$total+$amount;

    //         $amounts = number_format($totalAmount,2);

    //         $numto = new NumberToBangla();
    //         $amount = $numto->bnMoney((float)$amounts);



    // // return $this->invoice($holdingTax,$unions,$amount,$holdingBokeyas,'right',$TaxInvoice,$currentamount,$previousamount);
    //         $fileName = 'Invoice-'.date('Y-m-d H:m:s');
    //         $data['fileName'] = $fileName;
    //         $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L','default_font' => 'bangla',]);
    //         $mpdf->WriteHTML( $this->invoicePdf($row,$sonod,$uniouninfo,$TaxInvoice,$amount));
    //         $mpdf->Output($fileName,'I');

            $pdf = LaravelMpdf::loadView('invoice', compact('row', 'sonod', 'uniouninfo','TaxInvoice'));
            $pdf->stream("$EnsonodName-$row->sonod_Id.pdf");




        }
    }




    public function invoicePdf($sonod,$sonodName,$unions,$TaxInvoice,$amountWord){

        $full_name = $unions->full_name;
        $short_name_b = $unions->short_name_b;
        $thana = $unions->thana;
        $district = $unions->district;



        $maliker_name = $sonod->applicant_name;
        $father_or_samir_name = $sonod->applicant_father_name;
        $gramer_name = $sonod->applicant_present_village;
        $word_no = $sonod->applicant_present_word_number;
        $mobile_no = $sonod->applicant_mobile;


        $khatlist = $sonod->amount_deails;
        $khatlist = json_decode($khatlist);
        $total = $khatlist->tredeLisenceFee;
        $amount = ($total*$khatlist->vatAykor)/100;


        $totalAmount = $khatlist->pesaKor+$total+$amount;



        $invoiceId = $TaxInvoice->trxId;
        $status = $TaxInvoice->status;
        $created_at = date("d/m/Y", strtotime($TaxInvoice->created_at));
        $subtotal = number_format($TaxInvoice->amount,2);

        // <div style='text-align:right'>(ডিলারের কপি)</div>
        $html = "

        <style>
        @page {
            margin: 10px;
           }

        .memoborder{
            width: 48%;
        }

        .memo {
        //    width: 500px;
        //    margin:0 auto;
        //    padding:20px;
            background: white;

        }



        .memoHead {
            text-align: center;
            color:black
        }
        .companiname {
            margin:0;
        }
        p {

            color:black;
            margin:0;

        }div {

            color:black;
            margin:0;

        }
        p.defalttext.address {
            background:black;
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


        .thead .tr {
            color: black;
        }
        .thead .tr .th {
            color: black;
        }

        .tr {
            border: 1px solid black;
        }

        .th {
            border: 1px solid black;
            border-right: 1px solid white;
        }

        .td {
            border: 1px solid black;
        }
        .table,  .td {
          border: 1px solid black;
          border-collapse: collapse;
          text-align: center;
          color:black;
        }.th, {
          border: 1px solid white;
          border-collapse: collapse;
        }

        .td {
            height: 18.5px;

        }
        .slNo{
            float: right;
            width: 300px;
        }



.tdlist{
    height: 200px;
    vertical-align: top;
}

        </style>


    <div id='body'>

    <div class='memoborder' style='float:left' >
    <div class='memobg memobg1'>
            <div class='memo'>
            <div class='memoHead'>



            <p class='defalttext'>ইউপি ফরম-১০</p>
            <h2 style='font-weight: 500;' class='companiname'>$full_name</h2>
            <p class='defalttext'>উপজেলা: $thana, জেলা: $district  </p>
            <h2 class='companiname' style='  color: #410fcc;'>ট্যাক্স, রেট ও বিবিধ প্রাপ্তি আদায় রশিদ </h2>";

            if($status=='Paid'){
                $html .="            <h2 class='companiname' style='width: 160px;
                margin: 0 auto;
                background: green;
                color: white;
                border-radius: 50px;
                font-size: 16px;
                padding: 6px 0px;'>পরিশোধিত </h2>";
            }else{

                $html .="           <h2 class='companiname' style='width: 160px;
                margin: 0 auto;
                background: red;
                color: white;
                border-radius: 50px;
                font-size: 16px;
                padding: 6px 0px;'>অপরিশোধিত </h2>";
            }



            $html .="




        </div>

        <table style='width:100%'>
        <tr>
            <td colspan='2'></td>
            <td style='text-align:right'>রশিদ নং- ".int_en_to_bn($invoiceId)."</td>
        <tr>

        <tr>
            <td colspan='3'>$sonodName->bnname</td>

        <tr>

        <tr>
            <td >নাম: $maliker_name </td>
            <td colspan='2'>পিতার নাম- $father_or_samir_name</td>

        <tr>
        <tr>
            <td >ঠিকানা: গ্রাম- $gramer_name,</td>
            <td >ওয়ার্ড- ".int_en_to_bn($word_no)."</td>
            <td >ডাকঘর- $short_name_b</td>

        <tr>
        <tr>
            <td >উপজেলা: $thana </td>
            <td >জেলা: $district</td>
            <td >মোবাইল: ".int_en_to_bn($mobile_no)."</td>

        <tr>
        </table>
    <p></p>




                <div class='memobody' style='position: relative;'>

                    <div class='productDetails'>
                        <table class='table' style='border:1px solid #444B8F;width:100%' cellspacing='0'>
                            <thead class='thead'>
                                <tr class='tr'>
                                    <td class='th defaltfont' colspan='4' width='10%'>আদায়ের বিবরণ</td>
                                </tr>

                                <tr class='tr'>
                                    <td class='td defaltfont' width='5%'>ক্র. নং</td>
                                    <td class='td defaltfont' width='25%'>খাত</td>
                                    <td class='td defaltfont' width='15%'>বর্তমানে পরিশোধকৃত টাকা</td>
                                    <td class='td defaltfont' width='15%'>মোট টাকার পরিমাণ</td>



                                </tr>
                            </thead>
                            <tbody class='tbody'>";



                                    // $totalpay = $orders->pay;
                                    // $totaldue = $orders->due;
                                    $index = 1;

                                // $orderDetails = json_decode($orders->Invoices);



                                  $html .="  <tr class='tr'>
                                        <td class='td  defaltfont'>".int_en_to_bn(1)."</td>
                                        <td class='td  defaltfont'>পেশা কর</td>
                                        <td class='td  defaltfont'>".int_en_to_bn($khatlist->pesaKor)."</td>
                                        <td class='td  defaltfont'>".int_en_to_bn($khatlist->pesaKor)."</td>
                                    </tr>";



                                  $html .="  <tr class='tr'>
                                        <td class='td  defaltfont'>".int_en_to_bn(2)."</td>
                                        <td class='td  defaltfont'>ট্রেড লাইসেন্স ফি</td>
                                        <td class='td  defaltfont'>".int_en_to_bn($khatlist->tredeLisenceFee)."</td>
                                        <td class='td  defaltfont'>".int_en_to_bn($khatlist->tredeLisenceFee)."</td>
                                    </tr>";



                                  $html .="  <tr class='tr'>
                                        <td class='td tdlist defaltfont'>".int_en_to_bn(3)."</td>
                                        <td class='td tdlist defaltfont'>ভ্যাট ও আয়কর</td>
                                        <td class='td tdlist defaltfont'>".int_en_to_bn($amount)."</td>
                                        <td class='td tdlist defaltfont'>".int_en_to_bn($amount)."</td>
                                    </tr>";



                                        $index++;









                                $html .=" </tbody>
                            <tfoot class='tfoot'>";





                            $html .="
                            <tr class='tr'>
                            <td colspan='3' class='defalttext td defaltfont'style='text-align:right;    padding: 0 13px;'><p> মোট </p></td>
                            <td class='td defaltfont'>".int_en_to_bn($totalAmount)."</td>
                    </tr>


                            ";








                                $html .=" </tfoot>
                        </table>
                        <p style='margin-top:15px;padding:0 15px;' class='defaltfont'>কথায় : $amountWord</p>

                    </div>
                </div>
                <div class='memofooter' style='margin-top:25px'>
                    <p style='float:left;width:30%;padding:10px 15px' class='defaltfont'>ইউপি সচিব/আদায়কারীর স্বাক্ষর
                    </br>
                    তারিখ: ".int_en_to_bn($created_at)."
                    </p>

                    <p style='float:right;width:30%;text-align:right;padding:10px 15px' class='defaltfont'>ইউপি চেয়ারম্যানের স্বাক্ষর</p>
                </div>
            </div>
        </div>
        </div>



    <div class='memoborder' style='float:right' >
    <div class='memobg memobg1'>
            <div class='memo'>
            <div class='memoHead'>



            <p class='defalttext'>ইউপি ফরম-১০</p>
            <h2 style='font-weight: 500;' class='companiname'>$full_name</h2>
            <p class='defalttext'>উপজেলা: $thana, জেলা: $district  </p>
            <h2 class='companiname'  style='  color: #410fcc;'>ট্যাক্স, রেট ও বিবিধ প্রাপ্তি আদায় রশিদ </h2>";

            if($status=='Paid'){
                $html .="            <h2 class='companiname' style='width: 160px;
                margin: 0 auto;
                background: green;
                color: white;
                border-radius: 50px;
                font-size: 16px;
                padding: 6px 0px;'>পরিশোধিত </h2>";
            }else{

                $html .="           <h2 class='companiname' style='width: 160px;
                margin: 0 auto;
                background: red;
                color: white;
                border-radius: 50px;
                font-size: 16px;
                padding: 6px 0px;'>অপরিশোধিত </h2>";
            }



            $html .="




        </div>

        <table style='width:100%'>
        <tr>
        <td colspan='2'></td>
        <td style='text-align:right'>রশিদ নং- ".int_en_to_bn($invoiceId)."</td>
    <tr>

    <tr>
        <td colspan='3'>$sonodName->bnname</td>

    <tr>

        <tr>
            <td >নাম: $maliker_name </td>
            <td colspan='2'>পিতার নাম- $father_or_samir_name</td>

        <tr>
        <tr>
            <td >ঠিকানা: গ্রাম- $gramer_name,</td>
            <td >ওয়ার্ড- ".int_en_to_bn($word_no)."</td>
            <td >ডাকঘর- $short_name_b</td>

        <tr>
        <tr>
            <td >উপজেলা: $thana </td>
            <td >জেলা: $district</td>
            <td >মোবাইল: ".int_en_to_bn($mobile_no)."</td>

        <tr>
        </table>
    <p></p>




                <div class='memobody' style='position: relative;'>

                    <div class='productDetails'>
                        <table class='table' style='border:1px solid #444B8F;width:100%' cellspacing='0'>
                            <thead class='thead'>
                                <tr class='tr'>
                                    <td class='th defaltfont' colspan='4' width='10%'>আদায়ের বিবরণ</td>
                                </tr>

                                <tr class='tr'>
                                <td class='td defaltfont' width='5%'>ক্র. নং</td>
                                <td class='td defaltfont' width='25%'>খাত</td>
                                <td class='td defaltfont' width='15%'>বর্তমানে পরিশোধকৃত টাকা</td>
                                <td class='td defaltfont' width='15%'>মোট টাকার পরিমাণ</td>


                                </tr>
                            </thead>
                            <tbody class='tbody'>";



                                    // $totalpay = $orders->pay;
                                    // $totaldue = $orders->due;
                                    $index = 1;

                                // $orderDetails = json_decode($orders->Invoices);



                                $html .="  <tr class='tr'>
                                <td class='td  defaltfont'>".int_en_to_bn(1)."</td>
                                <td class='td  defaltfont'>পেশা কর</td>
                                <td class='td  defaltfont'>".int_en_to_bn($khatlist->pesaKor)."</td>
                                <td class='td  defaltfont'>".int_en_to_bn($khatlist->pesaKor)."</td>
                            </tr>";



                          $html .="  <tr class='tr'>
                                <td class='td  defaltfont'>".int_en_to_bn(2)."</td>
                                <td class='td  defaltfont'>ট্রেড লাইসেন্স ফি</td>
                                <td class='td  defaltfont'>".int_en_to_bn($khatlist->tredeLisenceFee)."</td>
                                <td class='td  defaltfont'>".int_en_to_bn($khatlist->tredeLisenceFee)."</td>
                            </tr>";



                          $html .="  <tr class='tr'>
                                <td class='td tdlist defaltfont'>".int_en_to_bn(3)."</td>
                                <td class='td tdlist defaltfont'>ভ্যাট ও আয়কর</td>
                                <td class='td tdlist defaltfont'>".int_en_to_bn($amount)."</td>
                                <td class='td tdlist defaltfont'>".int_en_to_bn($amount)."</td>
                            </tr>";



                                        $index++;









                                $html .=" </tbody>
                            <tfoot class='tfoot'>";



                            $html .="
                            <tr class='tr'>
                            <td colspan='3' class='defalttext td defaltfont'style='text-align:right;    padding: 0 13px;'><p> মোট </p></td>
                            <td class='td defaltfont'>".int_en_to_bn($totalAmount)."</td>
                    </tr>


                            ";







                                $html .=" </tfoot>
                        </table>
                        <p style='margin-top:15px;padding:0 15px;' class='defaltfont'>কথায় : $amountWord</p>

                    </div>
                </div>
                <div class='memofooter' style='margin-top:25px'>
                    <p style='float:left;width:30%;padding:10px 15px' class='defaltfont'>ইউপি সচিব/আদায়কারীর স্বাক্ষর
                    </br>
                    তারিখ: ".int_en_to_bn($created_at)."
                    </p>

                    <p style='float:right;width:30%;text-align:right;padding:10px 15px' class='defaltfont'>ইউপি চেয়ারম্যানের স্বাক্ষর</p>
                </div>
            </div>
        </div>
        </div>




        </div>



        ";


        return $html;
    }

















    public function userDocument(Request $request, $name, $id)
    {
        $row = Sonod::find($id);
        $sonod = Sonodnamelist::where('bnname', $row->sonod_name)->first();
        $uniouninfo = Uniouninfo::where('short_name_e', $row->unioun_name)->first();
        $sonodnames = Sonodnamelist::where(['bnname' => $row->sonod_name])->first();
        $EnsonodName = str_replace(" ", "_", $sonodnames->enname);
        if ($EnsonodName == 'Certificate_of_Inheritance' || $EnsonodName == 'Inheritance_certificate') {
            // return view('userdocumentUt',compact('row', 'sonod', 'uniouninfo'));
            $pdf = LaravelMpdf::loadView('userdocumentUt', compact('row', 'sonod', 'uniouninfo'));
            return $pdf->stream("$EnsonodName-$row->sonod_Id.pdf");
        } else {
            // return view('userdocument',compact('row', 'sonod', 'uniouninfo'));
            $pdf = LaravelMpdf::loadView('userdocument', compact('row', 'sonod', 'uniouninfo'));
            return $pdf->stream("$EnsonodName-$row->sonod_Id.pdf");
        }
    }
    public function sonod_search(Request $request)
    {
        $sonodcount =  Sonod::where(['sonod_name' => $request->sonod_name, 'sonod_Id' => $request->sonod_Id, 'stutus' => 'approved'])->count();
        if ($sonodcount > 0) {
            $Sonodnamelist =  Sonodnamelist::where(['bnname' => $request->sonod_name])->first();
            $sonod =  Sonod::where(['sonod_name' => $request->sonod_name, 'sonod_Id' => $request->sonod_Id, 'stutus' => 'approved'])->first();
            $sonod['sonodUrl'] = "/sonod/$Sonodnamelist->enname/$sonod->id";
            $sonod['searchstatus'] = "approved";
            return  $sonod;
        } else {
            $sonodcountall =  Sonod::where(['sonod_name' => $request->sonod_name, 'sonod_Id' => $request->sonod_Id])->count();
            if ($sonodcountall > 0) {
                $sonod =   Sonod::where(['sonod_name' => $request->sonod_name, 'sonod_Id' => $request->sonod_Id])->first();
                $sonod['searchstatus'] = "all";
                return $sonod;
            }
        }
        return 0;
    }
    public function singlesonod(Request $request, $id)
    {
        $admin = $request->admin;
        if($admin){
            $sonod =  Sonod::find($id);
            $sonodnamedata =  Sonodnamelist::where(['bnname'=>$sonod->sonod_name])->first();
            $sonod['image'] = asset($sonod->image);
            $sonod['applicant_national_id_front_attachment'] = asset($sonod->applicant_national_id_front_attachment);
            $sonod['applicant_national_id_back_attachment'] = asset($sonod->applicant_national_id_back_attachment);
            $sonod['applicant_birth_certificate_attachment'] = asset($sonod->applicant_birth_certificate_attachment);

           return $data = [
                'sonod'=>$sonod,
                'sonodnamedata'=>$sonodnamedata,
            ];
        }

        return Sonod::find($id);
    }



    public function sonodcountall(Request $request)
    {
        $userid = $request->userid;
        $union = $request->union;

        if($userid){
            $user = User::find($userid);
            if($user->position=='District_admin'){

                $district = $user->district;
                $unionlist = Uniouninfo::where('district',$district)->get();
            }else{

                $thana = $user->thana;
                $unionlist = Uniouninfo::where('thana',$thana)->get();
            }


            $total = [];
          foreach ($unionlist as $value) {
            array_push($total,

            [
                'Unionname'=>unionname($value->short_name_e)->full_name,
                'approved'=>Sonod::where(['stutus' => 'approved', 'unioun_name' => $value->short_name_e])->count(),
                'Secretary_approved'=>Sonod::where(['stutus' => 'Secretary_approved', 'unioun_name' => $value->short_name_e])->count(),
                'Pending'=>Sonod::where(['stutus' => 'Pending', 'unioun_name' => $value->short_name_e])->count(),
                'cancel'=>Sonod::where(['stutus' => 'cancel', 'unioun_name' => $value->short_name_e])->count(),
                ]

            );

          }
          return $total;


        }
    }


    public function totlaAmount(Request $request)
    {
        $userid = $request->userid;
        $union = $request->union;
        if ($union) {
            return Payment::where(['status' => 'Paid', 'union' => $union])->sum('amount');
        }elseif($userid){
            $user = User::find($userid);
            $thana = $user->thana;
            $unionlist = Uniouninfo::where('thana',$thana)->get();
            $totalamount = 0;
          foreach ($unionlist as $value) {
            // print_r($value->short_name_e);
            $totalamount += Payment::where(['union'=>$value->short_name_e,'status'=> 'Paid'])->sum('amount');
            # code...
          }
          return $totalamount;


        } else {
            return Payment::where('status', 'Paid')->sum('amount');
        }
    }




    public function counting(Request $request, $status)
    {
        $union = $request->union;
        $userid = $request->userid;

        if($userid){
            $user = User::find($userid);
            $thana = $user->thana;
            $unionlist = Uniouninfo::where('thana',$thana)->get();
            $allSonodCount = 0;
            $pendingSonodCount = 0;
            $approvedSonodCount = 0;
            $cancelSonodCount = 0;
            $total = 0;
          foreach ($unionlist as $value) {

            if ($status == 'all') {
                //  $total +=  Sonod::where('stutus', '!=', 'Prepaid')->where(['unioun_name' => $value->short_name_e])->count();
                 $allSonodCount +=  Sonod::where('stutus', '!=', 'Prepaid')->where(['unioun_name' => $value->short_name_e])->count();
                 $pendingSonodCount +=  Sonod::where('stutus', 'Pending')->where(['unioun_name' => $value->short_name_e])->count();
                 $approvedSonodCount +=  Sonod::where('stutus', 'approved')->where(['unioun_name' => $value->short_name_e])->count();
                 $cancelSonodCount +=  Sonod::where('stutus', 'cancel')->where(['unioun_name' => $value->short_name_e])->count();
            }else{

                // $total +=  Sonod::where(['stutus' => $status, 'unioun_name' => $value->short_name_e])->count();
                $allSonodCount += 0;
                $pendingSonodCount +=  Sonod::where(['stutus' => 'Pending', 'unioun_name' => $value->short_name_e])->count();
                $approvedSonodCount +=  Sonod::where(['stutus' => 'approved', 'unioun_name' => $value->short_name_e])->count();
                $cancelSonodCount +=  Sonod::where(['stutus' => 'cancel', 'unioun_name' => $value->short_name_e])->count();

            }
            # code...
          }



          $ReturnData = [
            'allSonodCount'=>$allSonodCount,
            'pendingSonodCount'=>$pendingSonodCount,
            'approvedSonodCount'=>$approvedSonodCount,
            'cancelSonodCount'=>$cancelSonodCount,
        ];


          return $ReturnData;


        }



        if ($union) {
            if ($status == 'all') {
                 $allSonodCount =  Sonod::where('stutus', '!=', 'Prepaid')->where(['unioun_name' => $union])->count();
                 $pendingSonodCount =  Sonod::where('stutus', 'Pending')->where(['unioun_name' => $union])->count();
                 $approvedSonodCount =  Sonod::where('stutus', 'approved')->where(['unioun_name' => $union])->count();
                 $cancelSonodCount =  Sonod::where('stutus', 'cancel')->where(['unioun_name' => $union])->count();

                $ReturnData = [
                    'allSonodCount'=>$allSonodCount,
                    'pendingSonodCount'=>$pendingSonodCount,
                    'approvedSonodCount'=>$approvedSonodCount,
                    'cancelSonodCount'=>$cancelSonodCount,
                ];
                return $ReturnData;




            }
            return  Sonod::where(['stutus' => $status, 'unioun_name' => $union])->count();
        }


        if ($status == 'all') {
            // return  Sonod::where('stutus', '!=', 'Prepaid')->count();

            $allSonodCount =  Sonod::where('stutus', '!=', 'Prepaid')->count();


        }
        $pendingSonodCount =  Sonod::where('stutus', 'Pending')->count();
        $approvedSonodCount =  Sonod::where('stutus', 'approved')->count();
        $cancelSonodCount =  Sonod::where('stutus', 'cancel')->count();

        $ReturnData = [
            'allSonodCount'=>$allSonodCount,
            'pendingSonodCount'=>$pendingSonodCount,
            'approvedSonodCount'=>$approvedSonodCount,
            'cancelSonodCount'=>$cancelSonodCount,
        ];


          return $ReturnData;

        // return  Sonod::where(['stutus' => $status])->count();
    }
    public function niddob(Request $request)
    {
        $applicant_national_id_number = $request->applicant_national_id_number;
        $applicant_birth_certificate_number = $request->applicant_birth_certificate_number;
        if ($applicant_national_id_number) {
            return   $citizen = Citizen::where(['nidno' => $applicant_national_id_number])->count();
        }
        if ($applicant_birth_certificate_number) {
            return   $citizen = Citizen::where(['dobno' => $applicant_birth_certificate_number])->count();
        }
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
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sonod  $sonod
     * @return \Illuminate\Http\Response
     */
    public function show(Sonod $sonod)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sonod  $sonod
     * @return \Illuminate\Http\Response
     */
    public function edit(Sonod $sonod)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sonod  $sonod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sonod $sonod)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sonod  $sonod
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sonod $sonod)
    {
        //
    }
    public function pdfHeader($id, $filename)
    {
        $row = Sonod::find($id);
        $sonod_name = $row->sonod_name;
        $sonod = Sonodnamelist::where('bnname', $row->sonod_name)->first();
        $uniouninfo = Uniouninfo::where('short_name_e', $row->unioun_name)->first();
        $sonodnames = Sonodnamelist::where(['bnname' => $row->sonod_name])->first();
        // return view('sonod',compact('row','sonod','uniouninfo'));
        $EnsonodName = str_replace(" ", "_", $sonodnames->enname);
        $w_list = $row->successor_list;
        $w_list = json_decode($w_list);
        $pdfHead = '';
        $ssName = '  <div class="nagorik_sonod" style="margin-bottom:10px;">
                <div style="
                background-color: #159513;
                color: #fff;
                font-size: 30px;
                border-radius: 30em;
                width:320px;
                margin:10px auto;
                margin-bottom:0px;
                text-align:center
                ">' . $sonod_name . '</div> <br>
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
        //   if ($Sname == 'successor_apps' || $Sname == 'ut') {}else{
        // 	     $output .= '<img width="100px" src="' . $logoPofile . '">';
        //   }
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
  </table>
                ' . $ssName . '
        ';
        return $output;
    }
    public function pdfFooter($id, $filename)
    {
        $row = Sonod::find($id);
        $sonod_name = $row->sonod_name;
        $sonod = Sonodnamelist::where('bnname', $row->sonod_name)->first();
        $uniouninfo = Uniouninfo::where('short_name_e', $row->unioun_name)->first();
        $sonodnames = Sonodnamelist::where(['bnname' => $row->sonod_name])->first();
        // return view('sonod',compact('row','sonod','uniouninfo'));
        $EnsonodName = str_replace(" ", "_", $sonodnames->enname);
        $sonodNO = ' <div class="signature text-center position-relative">
সনদ নং: ' .  int_en_to_bn($row->sonod_Id) . ' <br /> ইস্যুর তারিখ: '.int_en_to_bn(date("d/m/Y", strtotime($row->created_at))).'</div>';




$C_color = '#7230A0';
$C_size = '18px';
$color = 'black';
if($row->unioun_name=='dhamor'){
    $C_color = '#5c1caa';
    $C_size = '20px';
    $color = '#5c1caa';
}


            $ccc = '<img width="170px"  src="' . base64($row->chaireman_sign) . '"><br/>
                              <b><span style="color:'.$C_color.';font-size:'.$C_size.';">' . $row->chaireman_name . '</span> <br />
                                      </b><span style="font-size:16px;">চেয়ারম্যান</span><br />';



         $qrurl = url("/verification/sonod/$row->id?sonod_name=$sonod->enname&sonod_Id=$row->sonod_Id");

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
                            <p class="m-0" style="font-size:14px;text-align:center">ইস্যুকৃত সনদটি যাচাই করতে QR কোড স্ক্যান করুন অথবা ভিজিট করুন ' . $uniouninfo->domain . '</p>
                      </div>
                  </div>
              </div>

              ';

            //   <div class="nagorik_sonod" style="margin-bottom:10px;">
            //   <div style="
            //   background-color: black;
            //   color: white;
            //   font-size: 16px;
            //   border-radius: 30em;
            //   width:100px;
            //   margin:10px auto;
            //   text-align:center
            //   "> পাতা- '.int_en_to_bn("{PAGENO}").' </div>

            //             </div>

        $output = str_replace('<?xml version="1.0" encoding="UTF-8"?>', '', $output);
        return $output;
    }
    public function pdfHTMLut($id, $filename)
    {
        $row = Sonod::find($id);
        $sonod_name = $row->sonod_name;
        if ($sonod_name == 'ওয়ারিশান সনদ') {
            $text = 'ওয়ারিশ/ওয়ারিশগণের নাম ও সম্পর্ক';
        } else {
            $text = 'উত্তরাধিকারীগণের নাম ও সম্পর্ক';
        }
        $sonod = Sonodnamelist::where('bnname', $row->sonod_name)->first();
        $uniouninfo = Uniouninfo::where('short_name_e', $row->unioun_name)->first();
        $sonodnames = Sonodnamelist::where(['bnname' => $row->sonod_name])->first();
        // return view('sonod',compact('row','sonod','uniouninfo'));
        $EnsonodName = str_replace(" ", "_", $sonodnames->enname);
        $sonodurl = 'https://' . $_SERVER['HTTP_HOST'] . '/pdf/download' . '/' . $id;
        //in Controller
        $qrcode = \QrCode::size(70)
            ->format('svg')
            ->generate($sonodurl);
        $w_list = $row->successor_list;
        $w_list = json_decode($w_list);


$nagoriinfo = '';




if ($sonod_name == 'ওয়ারিশান সনদ') {
        $nagoriinfo .= '
            <p style="margin-top:0px;margin-bottom:5px;font-size:15px;text-align:justify">&nbsp; &nbsp; &nbsp; এই মর্মে প্রত্যয়ন করা যাচ্ছে যে, মরহুম ' . $row->utname . ', পিতা/স্বামী- ' . $row->ut_father_name . ', মাতা- ' . $row->ut_mother_name . ', গ্রাম- ' . $row->ut_grame . ', ডাকঘর- ' . $row->ut_post . ', উপজেলা: ' . $row->ut_thana . ', জেলা- ' . $row->ut_district . '। তিনি অত্র ইউনিয়নের '.int_en_to_bn($row->ut_word).' নং ওয়ার্ডের '.$row->applicant_resident_status.' বাসিন্দা ছিলেন। মৃত্যুকালে তিনি নিম্নোক্ত ওয়ারিশগণ রেখে যান। নিম্নে তাঁর ওয়ারিশ/ওয়ারিশগণের নাম ও সম্পর্ক উল্লেখ করা হলো।<br>
            <br>

            &nbsp; &nbsp; &nbsp; আমি মরহুমের বিদেহী আত্মার মাগফেরাত কামনা করি।
                </p>';
            } else {

            $nagoriinfo .= '
            <p style="margin-top:0px;margin-bottom:5px;font-size:15px;text-align:justify">&nbsp; &nbsp; &nbsp; এই মর্মে প্রত্যয়ন করা যাচ্ছে যে, জনাব ' . $row->utname . ', পিতা/স্বামী- ' . $row->ut_father_name . ', মাতা- ' . $row->ut_mother_name . ', গ্রাম- ' . $row->ut_grame . ', ডাকঘর- ' . $row->ut_post . ', উপজেলা: ' . $row->ut_thana . ', জেলা- ' . $row->ut_district . '। তিনি অত্র ইউনিয়নের '.int_en_to_bn($row->ut_word).' নং ওয়ার্ডের '.$row->applicant_resident_status.' বাসিন্দা। নিম্নে তাঁর উত্তরাধিকারী/উত্তরাধিকারীগণের নাম ও সম্পর্ক উল্লেখ করা হলো।<br>
            <br>


                </p>';



            }









 $nagoriinfo .= '<h4 style="text-align:center;margin-bottom:0px">' . $text . '</h4>
<table class="table " style="width:100%;border-collapse: collapse;" cellspacing="0" cellpadding="0"  >
<tr>
  <th style="        border: 1px dotted black;
        padding:4px 10px;
        font-size: 12px;" width="10%">ক্রমিক নং</th>
  <th style="        border: 1px dotted black;
        padding:4px 10px;
        font-size: 12px;" width="30%">নাম</th>
  <th style="        border: 1px dotted black;
        padding:4px 10px;
        font-size: 12px;" width="10%">সম্পর্ক</th>
  <th style="        border: 1px dotted black;
        padding:4px 10px;
        font-size: 12px;" width="10%">বয়স</th>
  <th style="        border: 1px dotted black;
        padding:4px 10px;
        font-size: 12px;" width="20%">জাতীয় পরিচয়পত্র নাম্বার/জন্মনিবন্ধন নাম্বার</th>
</tr>';
        $i = 1;
        foreach ($w_list as $rowList) {
            $nagoriinfo .= '
    <tr>
      <td style="text-align:center;        border: 1px dotted black;
        padding:4px 10px;
        font-size: 12px;">' . int_en_to_bn($i) . '</td>
      <td style="text-align:center;        border: 1px dotted black;
        padding:4px 10px;
        font-size: 12px;">' . $rowList->w_name . '</td>
      <td style="text-align:center;        border: 1px dotted black;
        padding:4px 10px;
        font-size: 12px;">' . $rowList->w_relation . '</td>
      <td style="text-align:center;        border: 1px dotted black;
        padding:4px 10px;
        font-size: 12px;">' . int_en_to_bn($rowList->w_age) . '</td>
      <td style="text-align:center;        border: 1px dotted black;
        padding:4px 10px;
        font-size: 12px;">' . int_en_to_bn($rowList->w_nid) . '</td>
    </tr>';
            $i++;
        }
        $nagoriinfo .= '
</table>
<br>
<p style="margin-top:-10px;margin-bottom:5px">
আবেদনকারীর নামঃ '.$row->applicant_name.'।  পিতা/স্বামীর নামঃ '.$row->applicant_father_name.'।  মাতার নামঃ '.$row->applicant_mother_name.'
</p><br>

<p style="margin-top:-10px;margin-bottom:5px">
সংশ্লিষ্ট ওয়ার্ডের ইউপি সদস্য কর্তৃক আবেদনকারীর দাখিলকৃত তথ্য যাচাই/সত্যায়নের পরিপ্রেক্ষিতে অত্র সনদপত্র প্রদান করা হলো।
</p> <br/>
<p style="margin-top:-10px; margin-bottom:0px">
&nbsp; &nbsp; &nbsp; আমি তাঁর/তাঁদের সর্বাঙ্গীন উন্নতি ও মঙ্গল কামনা করছি।
</p>
';

        $output = ' ';
        $output .= '' . $nagoriinfo . '';
        return $output;
    }




    public function verifysonodId(Request $request)
    {
        $sonod_name = $request->sonod_name;
        $sonod_name = Sonodnamelist::where(['enname'=>$sonod_name])->first()->bnname;
        $sonod_Id = $request->sonod_Id;


return Sonod::where(['sonod_name'=>$sonod_name,'sonod_Id'=>$sonod_Id])->first();

        // return $request->all();
    }



}
