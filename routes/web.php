<?php
use App\Models\Role;
use App\Models\Payment;
use App\Models\Visitor;
use App\Models\Uniouninfo;
use Illuminate\Http\Request;
use App\Models\Sonodnamelist;
use App\Models\TradeLicenseKhat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SonodController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HoldingtaxController;
use App\Http\Controllers\UniouninfoController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\NotificationsController;
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
        $redirect = "/payment/success/confirm?transId=$transId";

    }
// return;
    echo "
    <h3 style='text-align:center'>Please wait 5 seconds.This page is auto redirect you</h3>
    <script>
    setTimeout(() => {
    window.location.href='$redirect'
    }, 5000);
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
