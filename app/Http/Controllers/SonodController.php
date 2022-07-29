<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Sonod;
use App\Models\Payment;
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
            $sonod->update(['payment_status' => 'Paid']);
            // $sonod_name = sonodEnName($sonod->sonod_name);

            $deccription = "Congratulation! Your application has been Paid.Wait for Approval.";
            $messages = array();
            array_push(
                $messages,
                [
                    "number" => '88' . int_bn_to_en($sonod->applicant_mobile),
                    "message" => "$deccription"
                ]
            );
            ///sms functions
            try {
                $msgs = sendMessages($messages);
            } catch (Exception $e) {
                array_push($responsemessege, $e->getMessage());
            }
            return redirect("/document/$sonod->sonod_name/$id");



        } elseif ($payment_type == 'Postpaid') {

            $payment->update(['status' => 'Paid']);
            $sonod->update(['payment_status' => 'Paid']);
            // $sonod_name = sonodEnName($sonod->sonod_name);
            $sonodUrl =  url("/sonod/d/$id");
            $InvoiceUrl =  url("/invoice/d/$id");
            $deccription = "Congratulation! Your application has been Paid. Sonod : " . $sonodUrl . " Invoice : " . $InvoiceUrl;
            $messages = array();
            array_push(
                $messages,
                [
                    "number" => '88' . int_bn_to_en($sonod->applicant_mobile),
                    "message" => "$deccription"
                ]
            );
            ///sms functions
            try {
                $msgs = sendMessages($messages);
            } catch (Exception $e) {
                array_push($responsemessege, $e->getMessage());
            }
            return redirect("/sonod/$sonod->sonod_name/$id");

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


            $arraydata = [
                'total_amount' => $sonodnamelists->sonod_fee,
                'pesaKor' => $request->pesaKor,
                'tredeLisenceFee' => $request->tredeLisenceFee,
                'vatAykor' => $request->vatAykor,
                'khat' => $request->khat,
                'last_years_money' => 0,
                'currently_paid_money' => $sonodnamelists->sonod_fee,
            ];
            $amount_deails = json_encode($arraydata);
            $numto = new NumberToBangla();
            $the_amount_of_money_in_words = $numto->bnMoney($sonodnamelists->sonod_fee) . ' মাত্র';
            $updateData = [
                'khat' => $request->khat,
                'last_years_money' => 0,
                'currently_paid_money' => $sonodnamelists->sonod_fee,
                'total_amount' => $sonodnamelists->sonod_fee,
                'amount_deails' => $amount_deails,
                'the_amount_of_money_in_words' => $the_amount_of_money_in_words,
            ];

             $sonod->update($updateData);

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
    public function sonod_submit(Request $r)
    {
        //  $unioun_name =  $r->unioun_name;
        // $uniouninfo = Uniouninfo::where(['short_name_e'=>$unioun_name])->first();

        // $payment_type = $uniouninfo->payment_type;
        $successors = json_encode($r->successors);
        $sonodEnName =  Sonodnamelist::where('bnname', $r->sonod_name)->first();
        $filepath =  str_replace(' ', '_', $sonodEnName->enname);
        $Insertdata = [];
        $Insertdata = $r->except(['image', 'applicant_national_id_front_attachment', 'applicant_national_id_back_attachment', 'applicant_birth_certificate_attachment', 'successors']);
        $imageCount =  count(explode(';', $r->image));
        $national_id_frontCount =  count(explode(';', $r->applicant_national_id_front_attachment));
        $national_id_backCount =  count(explode(';', $r->applicant_national_id_back_attachment));
        $birth_certificateCount =  count(explode(';', $r->applicant_birth_certificate_attachment));
        if ($imageCount > 1) {
            $Insertdata['image'] =  fileupload($r->image, env('FILE_PATH')+"sonod/$filepath/image/", 250, 300);
        }
        if ($national_id_frontCount > 1) {
            $Insertdata['applicant_national_id_front_attachment'] =  fileupload($r->applicant_national_id_front_attachment, env('FILE_PATH')+"sonod/$filepath/applicant_national_id_front_attachment/", 250, 300);
        }
        if ($national_id_backCount > 1) {
            $Insertdata['applicant_national_id_back_attachment'] =  fileupload($r->applicant_national_id_back_attachment, env('FILE_PATH')+"sonod/$filepath/applicant_national_id_back_attachment/", 250, 300);
        }
        if ($birth_certificateCount > 1) {
            $Insertdata['applicant_birth_certificate_attachment'] =  fileupload($r->applicant_birth_certificate_attachment, env('FILE_PATH')+"sonod/$filepath/applicant_birth_certificate_attachment/", 250, 300);
        }
        $Insertdata['successor_list'] = $successors;
        $Uniouninfo =   Uniouninfo::where('short_name_e', $r->unioun_name)->latest()->first();
        $Insertdata['chaireman_name'] = $Uniouninfo->c_name;
        $Insertdata['chaireman_sign'] = $Uniouninfo->c_signture;
        try {


            $sonod =   sonod::create($Insertdata);



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
        //    return $request->all();
        $sonod = Sonod::find($id);
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
        $updateData = [
            'khat' => $request->khat,
            'last_years_money' => $request->last_years_money,
            'currently_paid_money' => $request->currently_paid_money,
            'total_amount' => $request->amounta,
            'amount_deails' => $amount_deails,
            'the_amount_of_money_in_words' => $the_amount_of_money_in_words,
            'stutus' => $request->approveData,
        ];
        return $sonod->update($updateData);
    }
    public function sonod_pay(Request $request, $id)
    {
        // return $request->all();
        $sonod = Sonod::find($id);
        $sonodUrl =  url("/sonod/d/$id");
        $InvoiceUrl =  url("/invoice/d/$id");
        $deccription = "Congratulation! Your application has been Paid. Sonod : " . $sonodUrl . " Invoice : " . $InvoiceUrl;
        $messages = array();
        array_push(
            $messages,
            [
                "number" => '88' . int_bn_to_en($sonod->applicant_mobile),
                "message" => "$deccription"
            ]
        );
        ///sms functions
        try {
            $msgs = sendMessages($messages);
        } catch (Exception $e) {
            array_push($responsemessege, $e->getMessage());
        }
        return $sonod->update(['payment_status' => 'Paid']);
    }
    public function sonod_action(Request $request, $action, $id)
    {
        //    return $action;
        $sonod = Sonod::find($id);
        $unioun_name = $sonod->unioun_name;
        $uniouninfos = Uniouninfo::where(['short_name_e' => $unioun_name])->first();
        if ($action == 'approved') {
            $updatedata = [
                'chaireman_name' => $uniouninfos->c_name,
                'chaireman_sign' => $uniouninfos->c_signture,
                'stutus' => $action,
            ];
            $sonod_name =  sonodEnName($sonod->sonod_name);
            $paymentUrl =  url("/sonod/payment/$id");
            $deccription = "Congratulation! Your application has been successfully approved. Click here to pay : " . $paymentUrl;
            $messages = array();
            array_push(
                $messages,
                [
                    "number" => '88' . int_bn_to_en($sonod->applicant_mobile),
                    "message" => "$deccription"
                ]
            );
            ///sms functions
            try {
                $msgs = sendMessages($messages);
            } catch (Exception $e) {
                array_push($responsemessege, $e->getMessage());
            }
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
        $sonod_name =  $this->enBnName($sonod_name)->bnname;
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
        return $datas->where(['sonod_name' => $sonod_name])->get();
    }
    public function sonodDownload(Request $request, $name, $id)
    {
        $row = Sonod::find($id);
        $sonod = Sonodnamelist::where('bnname', $row->sonod_name)->first();
        $uniouninfo = Uniouninfo::where('short_name_e', $row->unioun_name)->first();
        // return view('sonod',compact('row','sonod','uniouninfo'));
        $pdf = LaravelMpdf::loadView('sonod', compact('row', 'sonod', 'uniouninfo'));
        return $pdf->stream("pdf.pdf");
    }
    public function invoice(Request $request, $name, $id)
    {
        $row = Sonod::find($id);
         $row->unioun_name;
        $sonod = Sonodnamelist::where('bnname', $row->sonod_name)->first();
         $uniouninfo = Uniouninfo::where('short_name_e', $row->unioun_name)->first();
        $pdf = LaravelMpdf::loadView('invoice', compact('row', 'sonod', 'uniouninfo'));
         $pdf->stream("pdf.pdf");
    }
    public function userDocument(Request $request, $name, $id)
    {
        $row = Sonod::find($id);
        $sonod = Sonodnamelist::where('bnname', $row->sonod_name)->first();
        $uniouninfo = Uniouninfo::where('short_name_e', $row->unioun_name)->first();
        $pdf = LaravelMpdf::loadView('userdocument', compact('row', 'sonod', 'uniouninfo'));
        return $pdf->stream("pdf.pdf");
    }
    public function sonod_search(Request $request)
    {
        $sonodcount =  Sonod::where(['sonod_name' => $request->sonod_name, 'sonod_Id' => $request->sonod_Id, 'stutus' => 'approved'])->count();
        if ($sonodcount > 0) {
            $Sonodnamelist =  Sonodnamelist::where(['bnname' => $request->sonod_name])->first();
            $sonod =  Sonod::where(['sonod_name' => $request->sonod_name, 'sonod_Id' => $request->sonod_Id, 'stutus' => 'approved'])->first();
            $sonod['sonodUrl'] = "/sonod/$Sonodnamelist->enname/$sonod->id";
            return  $sonod;
        }
        return '';
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
}
