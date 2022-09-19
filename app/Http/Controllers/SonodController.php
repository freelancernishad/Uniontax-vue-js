<?php
namespace App\Http\Controllers;
use Exception;
use App\Models\Sonod;
use App\Models\Charage;
use App\Models\Citizen;
use App\Models\Payment;
use App\Models\ActionLog;
use App\Models\Uniouninfo;
use Illuminate\Http\Request;
use App\Models\Sonodnamelist;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Validator;
use Rakibhstu\Banglanumber\NumberToBangla;
use Meneses\LaravelMpdf\Facades\LaravelMpdf;
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
            $payment->update(['status' => 'Paid']);
            $sonod->update(['stutus' => 'Pending', 'payment_status' => 'Paid']);
            // $sonod_name = sonodEnName($sonod->sonod_name);
            $InvoiceUrl =  url("/invoice/c/$id");
            // $deccription = "অভিনন্দন! আপনার আবেদনটি সফলভাবে পরিশোধিত হয়েছে। অনুমোদনের জন্য অপেক্ষা করুন।";
            $deccription = "Congratulation! Your application $sonod->sonod_Id has been Paid.Wait for Approval.. Invoice: $InvoiceUrl";
            smsSend($deccription, $sonod->applicant_mobile);
            // return redirect("/document/$sonod->sonod_name/$id");
            echo "<script>window.close();</script>";
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
        $unioun_name =  $sonod->unioun_name;
        $sonod_name =  $sonod->sonod_name;
        $uniouninfo = Uniouninfo::where(['short_name_e' => $unioun_name])->first();
        $sonodnamelists = Sonodnamelist::where(['bnname' => $sonod_name])->first();
        $payment_type = $uniouninfo->payment_type;
        if ($payment_type == 'Prepaid') {
            $sonod_fee =  $sonodnamelists->sonod_fee;
            $unioninfos = Uniouninfo::where(['short_name_e' => $unioun_name])->first();
            $district = $unioninfos->district;
            $thana = $unioninfos->thana;
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
            $vatAmount = (($sonod_fee * $vat) / 100);
            $taxAmount = (($sonod_fee * $tax) / 100);
            $totalamount = $sonod_fee + $vatAmount + $taxAmount + $service;
            if ($totalamount == null || $totalamount == '' || $totalamount < 10) {
                $totalamount = 10;
            }
            $arraydata = [
                'total_amount' => $totalamount,
                'pesaKor' => $request->pesaKor,
                'tredeLisenceFee' => $request->tredeLisenceFee,
                'vatAykor' => $request->vatAykor,
                'khat' => $request->khat,
                'last_years_money' => 0,
                'currently_paid_money' => $totalamount,
            ];
            $amount_deails = json_encode($arraydata);
            $numto = new NumberToBangla();
            $the_amount_of_money_in_words = $numto->bnMoney($totalamount) . ' মাত্র';
            $updateData = [
                'khat' => $request->khat,
                'last_years_money' => 0,
                'currently_paid_money' => $totalamount,
                'total_amount' => $totalamount,
                'amount_deails' => $amount_deails,
                'the_amount_of_money_in_words' => $the_amount_of_money_in_words,
            ];
            $sonod->update($updateData);
            $total_amount = $sonod->total_amount;
            $amount = 0;
            if ($total_amount == null || $total_amount == '' || $total_amount < 10) {
                $amount = 10;
            } else {
                $amount = $total_amount;
            }
            $trnx_id = time();
            $cust_info = [
                "cust_email" => "",
                "cust_id" => "$sonod->sonod_Id",
                "cust_mail_addr" => "Address",
                "cust_mobo_no" => "$sonod->applicant_mobile",
                "cust_name" => "Customer Name"
            ];
            $req_timestamp = date('Y-m-d H:i:s');
            $customerData = [
                'union' => $sonod->unioun_name,
                'trxId' => $trnx_id,
                'sonodId' => $id,
                'sonod_type' => $sonod->sonod_name,
                'amount' => $amount,
                'mob' => $sonod->applicant_mobile,
                'status' => "Pending",
                'date' => date('Y-m-d'),
                'created_at' => $req_timestamp,
            ];
            Payment::create($customerData);
            $redirectutl =  ekpayToken($trnx_id, $amount, $cust_info);
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
                "cust_mobo_no" => "$sonod->applicant_mobile",
                "cust_name" => "Customer Name"
            ];
            $req_timestamp = date('Y-m-d H:i:s');
            $customerData = [
                'union' => $sonod->unioun_name,
                'trxId' => $trnx_id,
                'sonodId' => $id,
                'sonod_type' => $sonod->sonod_name,
                'amount' => $amount,
                'mob' => $sonod->applicant_mobile,
                'status' => "Pending",
                'date' => date('Y-m-d'),
                'created_at' => $req_timestamp,
            ];
            Payment::create($customerData);
            $redirectutl =  ekpayToken($trnx_id, $amount, $cust_info);
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
        $sortYear =  date('y');
        $UniouninfoCount =   Uniouninfo::where('short_name_e', $union)->latest()->count();
        $SonodCount =   Sonod::where(['unioun_name' => $union, 'sonod_name' => $sonodname, 'year' => date('Y')])->latest()->count();
        if ($UniouninfoCount > 0) {
            $Uniouninfo =   Uniouninfo::where('short_name_e', $union)->latest()->first();
            if ($SonodCount > 0) {
                $Sonod =  Sonod::where(['unioun_name' => $union, 'sonod_name' => $sonodname, 'year' => date('Y')])->latest()->first();
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
    public function sonod_submit(Request $r)
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
            return $sonod =   sonod::create($Insertdata);
            if ($stutus == 'Pending') {
                $deccription = "Congratulation! Your application $sonod->sonod_Id has been Submited.Wait for Approval";
                smsSend($deccription, $sonod->applicant_mobile);
            }
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
            $updateData = [
                'khat' => $request->khat,
                'last_years_money' => $request->last_years_money,
                'currently_paid_money' => $request->currently_paid_money,
                'total_amount' => $request->amounta,
                'the_amount_of_money_in_words' => $the_amount_of_money_in_words,
                'khat' => $request->khat,
                'amount_deails' => $amount_deails,
                'sec_prottoyon' => $sec_prottoyon,
                'stutus' => $request->approveData,
            ];
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
            'stutus' => $request->approveData,
        ];

        $Uniouninfo =   Uniouninfo::where('short_name_e', $sonod->unioun_name)->latest()->first();
        $updateData['chaireman_name'] = $Uniouninfo->c_name;
        $updateData['c_email'] = $Uniouninfo->c_email;
        $updateData['chaireman_sign'] = $Uniouninfo->c_signture;

        return $sonod->update($updateData);
    }
    public function sonod_pay(Request $request, $id)
    {
        // return $request->all();
        $sonod = Sonod::find($id);
        $sonodUrl =  url("/sonod/d/$id");
        $InvoiceUrl =  url("/invoice/d/$id");
        $deccription = "Congratulation! Your application $sonod->sonod_Id  has been Paid. Sonod : " . $sonodUrl . " Invoice : " . $InvoiceUrl;
        // $deccription = "অভিনন্দন! আপনার আবেদনটি সফলভাবে পরিশোধিত হয়েছে। সনদ : $sonodUrl রশিদ : $InvoiceUrl";
        smsSend($deccription, $sonod->applicant_mobile);
        $req_timestamp = date('Y-m-d H:i:s');
        $customerData = [
            'union' => $sonod->unioun_name,
            'trxId' => time(),
            'sonodId' => $id,
            'sonod_type' => $sonod->sonod_name,
            'amount' => $sonod->total_amount,
            'mob' => $sonod->applicant_mobile,
            'status' => "Paid",
            'date' => date('Y-m-d'),
            'created_at' => $req_timestamp,
        ];
        Payment::create($customerData);
        return $sonod->update(['payment_status' => 'Paid']);
    }
    public function cancelsonod(Request $request, $id)
    {
        $sonod = Sonod::find($id);
        $data = $request->all();
        ActionLog::create($data);
        $sonod->update(['cancedby' => $request->names, 'cancedbyUserid' => $request->user_id]);
        $InvoiceUrl =  url("/reject/$id");
        $deccription = "Opps! Your application $sonod->sonod_Id  has been Not Approve. Details : " . $InvoiceUrl;
        smsSend($deccription, $sonod->applicant_mobile);
        $updatedata = [
            'stutus' => $request->status,
        ];
        return $sonod->update($updatedata);
    }
    public function sonod_action(Request $request, $action, $id)
    {
        $sonod = Sonod::find($id);
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
                $deccription = "Congratulation! Your application $sonod->sonod_Id  has been Approved. Sonod : " . $sonodUrl . " Invoice : " . $InvoiceUrl;
                // $deccription = "অভিনন্দন! আপনার আবেদনটি সফলভাবে অনুমোদিত হয়েছে। সনদ : $sonodUrl রশিদ : $InvoiceUrl";
            } elseif ($payment_type == 'Postpaid') {
                $paymentUrl =  url("/sonod/payment/$id");
                $deccription = "Congratulation! Your application $sonod->sonod_Id  has been Approved. Pay: " . $paymentUrl;
                // $deccription = "অভিনন্দন! আপনার আবেদনটি সফলভাবে অনুমোদিত হয়েছে। আবেদনের ফি প্রদানের জন্য ক্লিক করুন " . $paymentUrl;
            }
            smsSend($deccription, $sonod->applicant_mobile);
        } else {
            $updatedata = [
                'stutus' => $action,
            ];
        }



        return $sonod->update($updatedata);
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
        if ($sondId) {
            // return $sondId;
            // return 'sss';
            return Sonod::where("sonod_Id", "LIKE", "%{$sondId}%")->where(['sonod_name' => $sonod_name, 'stutus' => $stutus, 'unioun_name' => $unioun_name])->orderBy('id', 'DESC')->paginate(20);
        }
        if ($unioun_name) {
            if ($payment_status) {
                return Sonod::where(['sonod_name' => $sonod_name, 'stutus' => $stutus, 'unioun_name' => $unioun_name, 'payment_status' => $payment_status])->orderBy('id', 'DESC')->paginate(20);
            }
            return Sonod::where(['sonod_name' => $sonod_name, 'stutus' => $stutus, 'unioun_name' => $unioun_name])->orderBy('id', 'DESC')->paginate(20);
        }
        return Sonod::where(['sonod_name' => $sonod_name, 'stutus' => $stutus])->orderBy('id', 'DESC')->paginate(20);
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
            $pdf = LaravelMpdf::loadView('sonod', compact('row', 'sonod', 'uniouninfo'));
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
        if ($name == 'c') {
            $pdf = LaravelMpdf::loadView('cinvoice', compact('row', 'sonod', 'uniouninfo'));
            $pdf->stream("$EnsonodName-$row->sonod_Id.pdf");
        } else {
            $pdf = LaravelMpdf::loadView('invoice', compact('row', 'sonod', 'uniouninfo'));
            $pdf->stream("$EnsonodName-$row->sonod_Id.pdf");
        }
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
        return Sonod::find($id);
    }
    public function totlaAmount(Request $request)
    {
        $union = $request->union;
        if ($union) {
            return Payment::where(['status' => 'Paid', 'union' => $union])->sum('amount');
        } else {
            return Payment::where('status', 'Paid')->sum('amount');
        }
    }
    public function counting(Request $request, $status)
    {
        $union = $request->union;
        if ($union) {
            if ($status == 'all') {
                return  Sonod::where('stutus', '!=', 'Prepaid')->where(['unioun_name' => $union])->count();
            }
            return  Sonod::where(['stutus' => $status, 'unioun_name' => $union])->count();
        }
        if ($status == 'all') {
            return  Sonod::where('stutus', '!=', 'Prepaid')->count();
        }
        return  Sonod::where(['stutus' => $status])->count();
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
সনদ নং: ' .  int_en_to_bn($uniouninfo->u_code . '11-' . $uniouninfo->sonod_no) . ' <br /> ইস্যুর তারিখ: </div>';




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





        $qrurl = url("/verification/sonod/$row->id");
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
            <p style="margin-top:0px;margin-bottom:5px;font-size:15px;text-align:justify">&nbsp; &nbsp; &nbsp; এই মর্মে প্রত্যয়ন করা যাচ্ছে যে, মরহুম ' . $row->utname . ', পিতা- ' . $row->ut_father_name . ', মাতা- ' . $row->ut_mother_name . ', গ্রাম- ' . $row->applicant_permanent_village . ', ডাকঘর- ' . $row->applicant_permanent_post_office . ', উপজেলা: ' . $row->applicant_permanent_Upazila . ', জেলা- ' . $row->applicant_permanent_district . '। তিনি অত্র ইউনিয়নের '.int_en_to_bn($row->applicant_permanent_word_number).' নং ওয়ার্ডের '.$row->applicant_resident_status.' বাসিন্দা ছিলেন। মৃত্যুকালে তিনি নিম্নোক্ত ওয়ারিশগণ রেখে যান। নিম্নে তাঁর ওয়ারিশ/ওয়ারিশগণের নাম ও সম্পর্ক উল্লেখ করা হলো।<br>
            <br>

            &nbsp; &nbsp; &nbsp; আমি মরহুমের বিদেহী আত্মার মাগফেরাত কামনা করি।
                </p>';
            } else {

            $nagoriinfo .= '
            <p style="margin-top:0px;margin-bottom:5px;font-size:15px;text-align:justify">&nbsp; &nbsp; &nbsp; এই মর্মে প্রত্যয়ন করা যাচ্ছে যে, জনাব ' . $row->utname . ', পিতা- ' . $row->ut_father_name . ', মাতা- ' . $row->ut_mother_name . ', গ্রাম- ' . $row->applicant_permanent_village . ', ডাকঘর- ' . $row->applicant_permanent_post_office . ', উপজেলা: ' . $row->applicant_permanent_Upazila . ', জেলা- ' . $row->applicant_permanent_district . '। তিনি অত্র ইউনিয়নের '.int_en_to_bn($row->applicant_permanent_word_number).' নং ওয়ার্ডের '.$row->applicant_resident_status.' বাসিন্দা। নিম্নে তাঁর উত্তরাধিকারী/উত্তরাধিকারীগণের নাম ও সম্পর্ক উল্লেখ করা হলো।<br>
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
আবেদনকারীর নামঃ '.$row->applicant_name.'।  পিতার নামঃ '.$row->applicant_father_name.'।  মাতার নামঃ '.$row->applicant_mother_name.'
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
}
