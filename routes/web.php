<?php
use App\Models\Role;
use App\Models\Visitor;
use App\Models\Uniouninfo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SonodController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HoldingtaxController;
use App\Http\Controllers\UniouninfoController;
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
Route::get('/smstest', function () {

    for ($i=0; $i <6 ; $i++) {
        smsSend('hello test');
    }


});

Route::get('/unioncreate', function () {

return view('unioncreate');


});

Route::post('unionCreate', [UniouninfoController::class,'unionCreate']);
// Auth::routes();
Route::post('login',[LoginController::class,'login']);
Route::post('logout',[LoginController::class,'logout']);
// Route::group(['middleware' => ['is_admin']], function() {
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });
// Route::group(['middleware' => ['CustomerMiddleware']], function() {
// Route::get('/sub', [App\Http\Controllers\HomeController::class, 'sub'])->name('sub');
// });

Route::get('/payment/success', [SonodController::class,'sonodpaymentSuccess']);
Route::get('/sonod/payment/{id}', [SonodController::class,'sonodpayment']);
Route::get('/sonod/{name}/{id}', [SonodController::class,'sonodDownload']);
Route::get('/invoice/{name}/{id}', [SonodController::class,'invoice']);
Route::get('/document/{name}/{id}', [SonodController::class,'userDocument']);
Route::get('/pay/holding/tax/{id}', [HoldingtaxController::class,'holding_tax_pay_Online']);
Route::get('/holdingPay/success', [HoldingtaxController::class,'holdingPaymentSuccess']);
Route::group(['prefix' => 'dashboard','middleware' => ['auth']], function() {
    Route::get('/{vue_capture?}', function () {
        // return   Auth::user()->roles->permission;
        $roles = Role::all();
        return view('layout',compact('roles'));
    })->where('vue_capture', '[\/\w\.-]*')->name('dashboard');
});
Route::get('/{vue_capture?}', function () {

    $url = url()->current();
 $domain =  explode('//',$url);

  $subdomain =  explode('.', $domain[1]);

    if($subdomain[0]=='www'){
       
         $subdomainCount =  count($subdomain);
         $subdomainget = $subdomain[1];
        if($subdomainCount>4){
            $sub = true;
        }else{
            $sub = false;

        }
    }else{


        $subdomainCount =  count($subdomain);
        $subdomainget = $subdomain[0];

        if($subdomainCount>3){
            $sub = true;
        }else{
            $sub = false;

        }
    }


 if($sub){

    $uniounDetials =  Uniouninfo::where(['short_name_e'=>$subdomainget])->first();
     return view('frontlayout',compact('uniounDetials'));
    }else{




        // return  Uniouninfo::find(1);
 $uniounDetials['defaultColor']  = 'green';
      $uniounDetials = json_decode(json_encode($uniounDetials));
     return view('frontlayout',compact('uniounDetials'));
 }
})->where('vue_capture', '[\/\w\.-]*')->name('frontend');
