<?php
use App\Models\Role;
use App\Models\Sonod;
use App\Models\Tender;
use App\Models\Payment;
use App\Models\Visitor;
use App\Models\TenderList;
use App\Models\Uniouninfo;
use Illuminate\Http\Request;
use App\Models\Sonodnamelist;
use App\Models\TradeLicenseKhat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\SonodController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DynamicPDFController;
use App\Http\Controllers\HoldingtaxController;
use App\Http\Controllers\UniouninfoController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\TenderListController;
use lemonpatwari\bangladeshgeocode\Models\Division;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/pdf/download/{Sname}/{id}', function () {
//     return 'sss';
//    });



Route::get('/pdf/tenders/{tender_id}', [TenderListController::class,'viewpdf']);


Route::get('/tenders/{tender_id}', function ($tender_id) {


    $tender_list_count = TenderList::where('tender_id',$tender_id)->count();
    if($tender_list_count<1){
        return 'No data Found';
    }

    $tender_list = TenderList::where('tender_id',$tender_id)->first();
    $tenderCount =  Tender::where('tender_id',$tender_list->id)->count();
    if($tenderCount>0){
        $tender = Tender::where('tender_id',$tender_list->id)->orderBy('id','desc')->first();
        $dorId = $tender->dorId+1;
    }else{
        $dorId = 120001;
    }



    // return view('form');
      $currentDate = strtotime(date("d-m-Y H:i:s"));

    $startDate = strtotime(date("d-m-Y H:i:s",strtotime($tender_list->tender_start)));

    $EndDate = strtotime(date("d-m-Y H:i:s",strtotime($tender_list->tender_end)));


    // <h1 style='text-align:center;margin-top:20px;color:green'>ফলাফল এর জন্য অপেক্ষা করুন :- ".date('d-m-Y h:i A',strtotime($tender_list->tender_open))."  পর্যন্ত</h1>

   if($currentDate>$EndDate){


       if($tender_list->status=='Completed'){
        $selectedPerson = Tender::where(['tender_id'=>$tender_list->id,'status'=>'Selected'])->get();

        $table = "";
        $table .="
        <table class='table' border='1' style='border-collapse:collapse'>
        <thead>
            <tr>
            <th scope='col'>দরপত্র নম্বর</th>
            <th scope='col'>নাম</th>
            <th scope='col'>পিতার নাম</th>
            <th scope='col'>ঠিকানা</th>
            <th scope='col'>মোবাইল</th>
            <th scope='col'>দরের পরিমাণ</th>
            <th scope='col'>কথায়</th>
            <th scope='col'>জামানতের পরিমাণ</th>
            </tr>
        </thead>
        <tbody>";

        foreach ($selectedPerson as $application) {


            $table .="
            <tr>
            <th scope='row'>$application->dorId</th>
                <td>$application->applicant_orgName</td>
                <td>$application->applicant_org_fatherName</td>
                <td>গ্রাম- $application->vill, ডাকঘর- $application->postoffice, উপজেলা- $application->thana, জেলা- $application->distric</td>
                <td>$application->mobile</td>
                <td>$application->DorAmount</td>
                <td>$application->DorAmountText</td>
                <th>$application->depositAmount</td>
                </tr>";

            }


        $table .="</tbody>
        </table>";


        return "

            <style>

            table {
                width: 100%;
                border-collapse: collapse;
            }

            tr:nth-of-type(odd) {
                background: #eee;
            }
            th {
                background: green;
                color: white;
                font-weight: bold;
            }
            td, th {
                padding: 6px;
                border: 1px solid #ccc;
                text-align: left;
            }
            </style>

        <h1 style='text-align:center;margin-top:20px;color:green'>এই ইজারার নির্বাচিত সদস্যা এর তথ্য নিচে দেখুন।</h1>

            $table


        ";
    }else{
        $tender_list->update(['status'=>'proccesing']);
        return "
        <h1 style='text-align:center;margin-top:20px;color:red'>দরপত্র দাখিলের সময় শেষ</h1>
        <h1 style='text-align:center;margin-top:20px;color:green'>ফলাফল এর জন্য অপেক্ষা করুন </h1>
        ";
    }





    }

   if($currentDate>$startDate){
    $tender_list->update(['status'=>'active']);
       return view('tender.form',compact('dorId','tender_list'));
    }else{

        return view('tender.countdown',compact('tender_list'));
   }





});

Route::post('/form/submit', function (Request $request) {

        $data = $request->except(['_token','bank_draft_image','deposit_details']);
        $bank_draft_image = $request->file('bank_draft_image');
        $extension = $bank_draft_image->getClientOriginalExtension();
        $path = public_path('files/bank_draft_image/');
        $fileName = $request->dorId.'-'.uniqid().'.'.$extension;
        $bank_draft_image->move($path, $fileName);
        $bank_draft_image = asset('files/bank_draft_image/'.$fileName);

        $deposit_details = $request->file('deposit_details');
        $extension = $deposit_details->getClientOriginalExtension();
        $path = public_path('files/deposit_details/');
        $fileName = $request->dorId.'-'.uniqid().'.'.$extension;
        $deposit_details->move($path, $fileName);
        $deposit_details = asset('files/deposit_details/'.$fileName);

        $data['bank_draft_image'] = $bank_draft_image;
        $data['deposit_details'] = $deposit_details;

      Tender::create($data);
      Session::flash('Smessage', 'আপনার দরপত্রটি দাখিল হয়েছে');
      return redirect()->back();


    });


Route::get('/pdf/sder/download/{tender_id}', function (Request $request,$tender_id) {

    $html = '
    <style>
    td{
        border: 1px solid black;
        padding:4px 10px;
        font-size: 14px;
    }    th{
        border: 1px solid black;
        padding:4px 10px;
        font-size: 14px;
    }
    </style>
        <p style="text-align:center;font-size:25px">দরপত্র দাখিল কারীর তালিকা</p>


    <table class="table" border="1" style="border-collapse: collapse;width:100%">
    <thead>
        <tr>
        <td>দরপত্র নম্বর</td>
        <td>নাম</td>
        <td>পিতার নাম</td>
        <td>ঠিকানা</td>
        <td>মোবাইল</td>
        <td>দরের পরিমাণ</td>
        <td>কথায়</td>
        <td>জামানতের পরিমাণ</td>
        </tr>
    </thead>
    <tbody>';
            $tenders =  Tender::where('tender_id',$tender_id)->get();
        foreach ($tenders as $application) {


        $html .= " <tr>
            <td>$application->dorId</td>
            <td>$application->applicant_orgName</td>
            <td>$application->applicant_org_fatherName</td>
            <td>গ্রাম- $application->vill, ডাকঘর- $application->postoffice, উপজেলা- $application->thana, জেলা- $application->distric</td>
            <td>$application->mobile</td>
            <td>$application->DorAmount</td>
            <td>$application->DorAmountText</td>
            <td>$application->depositAmount</td>
        </tr>";
    }


        $html .= '

    </tbody>
    </table>



    ';
       return PdfMaker('A4',$html,'list',false);



    });





















Route::get('/invoice/view/{id}', [DynamicPDFController::class,'viewpdf']);


Route::get('/pdf/download/{Sname}/{id}', [DynamicPDFController::class,'pdf']);


Route::get('/invoices/{id}', [DynamicPDFController::class,'convert_customer_data_to_html']);

Route::get('/pdfC', [DynamicPDFController::class,'pdfC']);






Route::get('/akpay/test', function () {


    $trnx_id = time();

    $Apiurl = 'https://pg.ekpay.gov.bd/ekpaypg/v1';
    $url = 'https://uniontax.gov.bd';

    $whitelistip = '192.64.117.77';
   $req_timestamp = date('Y-m-d H:i:s');

 $AKPAY_MER_REG_ID = 'tetulia01_mer';
$AKPAY_MER_PASS_KEY = 'Tet@merEK091';





   $post = [
      'mer_info' => [
         "mer_reg_id" => $AKPAY_MER_REG_ID,
         "mer_pas_key" => $AKPAY_MER_PASS_KEY
      ],
      "req_timestamp" => "$req_timestamp GMT+6",
      "feed_uri" => [
         "c_uri" => url("payment/cancel"),
         "f_uri" => url("payment/fail"),
         "s_uri" => url("payment/success")
      ],
      "cust_info" => [
        "cust_email" => "",
        "cust_id" => "1",
        "cust_mail_addr" => "Address",
        "cust_mobo_no" => "01909756552",
        "cust_name" => "Customer Name"
    ],
      "trns_info" =>[
        "ord_det" => 'sonod',
        "ord_id" => "1",
        "trnx_amt" => 10,
        "trnx_currency" => "BDT",
        "trnx_id" => "$trnx_id"
    ],
      "ipn_info" => [
         "ipn_channel" => "3",
         "ipn_email" => "freelancernishad123@gmail.com",
         "ipn_uri" => "$url/api/ipn"
      ],
      "mac_addr" => "$whitelistip"
   ];

   // 148.163.122.80
   $post = json_encode($post);


   $ch = curl_init($Apiurl.'/merchant-api');
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
   $response = curl_exec($ch);
   curl_close($ch);

/*      echo '<pre>';
   print_r($response); */


  return   $response = json_decode($response);
   $sToken =  $response->secure_token;


   return "$Apiurl?sToken=$sToken&trnsID=$trnx_id";









});





Route::get('/textemail', function () {

    $year = date('Y');
    $date = date('m');
    $orthobochor = '';
    if($date<7){
        $orthobochor = ($year-1)."-".date('y');
    }else{
        $orthobochor = $year."-".date('y')+1;
    }

    return $orthobochor;
    die();


    $deccriptionEmail = "Your application no. 77349852200010 has been approved. Document is available at https://test.uniontax.gov.bd/sonod/d/22425";
    $emaildata= ['deccription'=>$deccriptionEmail];
return view('email_view',$emaildata);


});

Route::get('/smstest', function () {

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];
    $subject = 'hello subject';

    \Mail::to('freelancernishad123@gmail.com')->send(new \App\Mail\MyTestMail($details,$subject));

    dd("Email is Sent.");


});

Route::get('details',[NotificationsController::class,'details']);




Route::get('/unioncreate', function () {

return view('unioncreate');


});

Route::post('unionCreate', [UniouninfoController::class,'unionCreate']);
Auth::routes([
    'login'=>false,
]);
Route::post('login',[LoginController::class,'login']);
Route::post('logout',[LoginController::class,'logout']);
// Route::group(['middleware' => ['is_admin']], function() {
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });
// Route::group(['middleware' => ['CustomerMiddleware']], function() {
// Route::get('/sub', [App\Http\Controllers\HomeController::class, 'sub'])->name('sub');
// });






Route::get('/sonod/payment/success/{id}', [SonodController::class,'sonodpaymentSuccessView']);


Route::get('/payment/success', function (Request $request) {
    // return $request->all();
    $transId = $request->transId;

    $payment = Payment::where(['trxId' => $transId])->first();


    if($payment->sonod_type=='holdingtax'){
        $redirect = "/holdingPay/success?transId=$transId";
    }else{

        $sonod = Sonod::find($payment->sonodId);
        if($sonod->pBy=='Pre Pay'){

            $redirect = "/applications/final/form?sToken=$sonod->uniqeKey";
        }else{
            $redirect = "/payment/success/confirm?transId=$transId";

        }



    }


// return;
    echo "
    <h3 style='text-align:center'>Please wait 10 seconds.This page will auto redirect you</h3>
    <script>
    setTimeout(() => {
    window.location.href='$redirect'
    }, 10000);
    </script>
    ";
    // return redirect("/payment/success/confirm?transId=$transId");
});


Route::get('/payment/success/confirm', [SonodController::class,'sonodpaymentSuccess']);




Route::get('/sonod/payment/{id}', [SonodController::class,'sonodpayment']);


Route::get('/sonod/{name}/{id}', [SonodController::class,'sonodDownload']);
Route::get('/invoice/{name}/{id}', [SonodController::class,'invoice']);
Route::get('/document/{name}/{id}', [SonodController::class,'userDocument']);
Route::get('/pay/holding/tax/{id}', [HoldingtaxController::class,'holding_tax_pay_Online']);


Route::get('/holdingPay/success', [HoldingtaxController::class,'holdingPaymentSuccess']);



Route::get('holding/tax/bokeya/list',[HoldingtaxController::class,'bokeyaReport']);



Route::get('/holding/tax/certificate_of_honor/{id}', [HoldingtaxController::class,'holdingCertificate_of_honor']);
Route::get('/holding/tax/invoice/all/list', [HoldingtaxController::class,'holdingAllPenddingInvoice']);
Route::get('/holding/tax/invoice/{id}', [HoldingtaxController::class,'holdingPaymentInvoice']);

Route::get('/report/export', [PaymentController::class,'export']);

Route::get('/cashbook/download', [ExpenditureController::class,'cashbook_download']);

Route::get('/secretary/approve/{id}', [SonodController::class,'SecretariNotificationApprove']);
Route::get('/chairman/approve/{id}', [SonodController::class,'ChairnamNotificationApprove']);
Route::get('/secretary/pay/{id}', [SonodController::class,'SecretariNotificationPay']);
Route::get('/allow/application/notification', function () {

    return view('applicationNotification');


    });





Route::group(['prefix' => 'dashboard','middleware' => ['auth']], function() {



    Route::get('/{vue_capture?}', function () {
        // return   Auth::user()->roles->permission;
        $roles = Role::all();
        $Sonodnamelist =  Sonodnamelist::all();




        return view('layout',compact('roles','Sonodnamelist'));
    })->where('vue_capture', '[\/\w\.-]*')->name('dashboard');
});


Route::get('/{vue_capture?}', function () {

    $url = url()->current();
 $domain =  explode('//',$url);

  $subdomain =  explode('.', $domain[1]);

    if($subdomain[0]=='www'){

         $subdomainCount =  count($subdomain);
         $subdomainget = $subdomain[1];
        if($subdomainCount>env('WITH_WWW')){
            $sub = true;
        }else{
            $sub = false;

        }
    }else{


        $subdomainCount =  count($subdomain);
        $subdomainget = $subdomain[0];

        if($subdomainCount>env('WITHOUT_WWW')){
            $sub = true;
        }else{
            $sub = false;

        }
    }

    // return $sonodnamesprops = Sonodnamelist::all();


    // $sonodnamesprops = Sonodnamelist::select(['id','service_id','bnname','enname','icon'])->get();
   $sonodnamesprops = cache()->remember('sonodnamesprops', 60*60*24, function () {
        return Sonodnamelist::select(['id','service_id','bnname','enname','icon'])->get();
    });



    $allDivision = cache()->remember('allDivision', 60*60*24, function () {
        return Division::all();
    });

    $tradeLicenseKhat = cache()->remember('tradeLicenseKhat', 60*60*24, function () {
        return TradeLicenseKhat::where(['type'=>'main'])->get();
    });

    // $tradeLicenseKhat = TradeLicenseKhat::where(['type'=>'main'])->get();

// return 'uniounDetials-'.$subdomainget;


 if($sub){

    // $uniounDetials =  Uniouninfo::where(['short_name_e'=>$subdomainget])->first();

    $uniounDetials = cache()->remember('uniounDetials-'.$subdomainget, 60*60*24, function () use($subdomainget) {
        return Uniouninfo::where(['short_name_e'=>$subdomainget])->first();
    });
     return view('frontlayout',compact('uniounDetials','sonodnamesprops','allDivision','tradeLicenseKhat'));
    }else{




        // return  Uniouninfo::find(1);
 $uniounDetials['defaultColor']  = 'green';
    //   $uniounDetials = json_decode(json_encode($uniounDetials));
    //   $uniounDetials =  Uniouninfo::where(['short_name_e'=>'uniontax'])->first();
      $uniounDetials = cache()->remember('uniounDetials-uniontax', 60*60*24, function () {
        return Uniouninfo::where(['short_name_e'=>'uniontax'])->first();
    });
     return view('frontlayout',compact('uniounDetials','sonodnamesprops','allDivision','tradeLicenseKhat'));
 }
})->where('vue_capture', '[\/\w\.-]*')->name('frontend');







