<?php

use App\Models\Tender;
use App\Models\TenderList;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\blogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SonodController;
use App\Http\Controllers\CharageController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VisitorController;
use  App\Http\Controllers\api\authController;
use App\Http\Controllers\ActionLogController;
use App\Http\Controllers\countryApiController;
use App\Http\Controllers\HoldingtaxController;
use App\Http\Controllers\TenderListController;
use App\Http\Controllers\UniouninfoController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\HoldingBokeyaController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\SonodnamelistController;
use App\Http\Controllers\TanderInvoiceController;
use App\Http\Controllers\TenderFormBuyController;
use App\Http\Controllers\TradeLicenseKhatController;
use App\Http\Controllers\CitizenInformationController;
use App\Http\Controllers\TradeLicenseKhatFeeController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [authController::class,'login']);
    Route::post('logout', [authController::class,'logout']);
    Route::post('refresh', [authController::class,'refresh']);
    Route::post('me', [authController::class,'login']);

});

Route::post('nagorik/seba/inserts',[SonodController::class, 'sonod_submit']);

Route::post('nagorik/pre/pay/inserts',[SonodController::class, 'sonod_submit_pre_pay']);

Route::get('get/sonod/by/key',[SonodController::class,'sonodByKey']);


// country api
Route::get('/getdivisions', [countryApiController::class,'getdivisions']);
Route::get('/getdistrict', [countryApiController::class,'getdistrict']);
Route::get('/getthana', [countryApiController::class,'getthana']);
Route::get('/getunioun', [countryApiController::class,'getunioun']);
Route::get('/gotoUnion', [countryApiController::class,'gotoUnion']);




Route::post('unionCreate', [UniouninfoController::class,'unionCreate']);

Route::post('nid/service/{union}', [UniouninfoController::class,'unionservicecheck']);
Route::post('nid/check/{union}', [UniouninfoController::class,'unioncheck']);




Route::resources([
    'tradeLicenseKhat' => TradeLicenseKhatController::class,
	'tradeLicenseKhatFee' => TradeLicenseKhatFeeController::class,
	'tender' => TenderListController::class,
	'tenderform' => TenderFormBuyController::class,
]);



Route::post('tender/selection/{tender_id}', [TenderListController::class,'SeletionTender']);

    Route::post('committe/update/{id}', function (Request $request,$id) {

        $committe1name = $request->committe1name;
        $committe1position = $request->committe1position;
        $commette1phone = $request->commette1phone;

        $committe2name = $request->committe2name;
        $committe2position = $request->committe2position;
        $commette2phone = $request->commette2phone;

        $committe3name = $request->committe3name;
        $committe3position = $request->committe3position;
        $commette3phone = $request->commette3phone;




        $updatedData = [
            'committe1name'=> $committe1name,
            'committe1position'=> $committe1position,
            'commette1phone'=> $commette1phone,
            'commette1pass'=> mt_rand(1000000, 9999999),
            'committe2name'=> $committe2name,
            'committe2position'=> $committe2position,
            'commette2phone'=> $commette2phone,
            'commette2pass'=> mt_rand(1000000, 9999999),
            'committe3name'=> $committe3name,
            'committe3position'=> $committe3position,
            'commette3phone'=> $commette3phone,
            'commette3pass'=> mt_rand(1000000, 9999999),
        ];



        $tenderList = TenderList::find($id);

        SmsNocSmsSend("ইযারা মূল্যায়নের পাসওয়ার্ড ".$updatedData['commette1pass'],$updatedData['commette1phone'],$tenderList->union_name);
        SmsNocSmsSend("ইযারা মূল্যায়নের পাসওয়ার্ড ".$updatedData['commette2pass'],$updatedData['commette2phone'],$tenderList->union_name);
        SmsNocSmsSend("ইযারা মূল্যায়নের পাসওয়ার্ড ".$updatedData['commette3pass'],$updatedData['commette3phone'],$tenderList->union_name);




        // return $updatedData;

        $tenderList->update($updatedData);



    });

Route::get('get/all/aplications/{tender_id}', function (Request $request,$tender_id) {

    $status = $request->status;
    if($status){
        return Tender::where(['tender_id'=>$tender_id,'status'=>$status,'payment_status'=>'Paid'])->get();
    }else{
        return Tender::where(['tender_id'=>$tender_id,'payment_status'=>'Paid'])->orderBy('DorAmount','desc')->get();
    }
  });

Route::get('get/all/tender/list', function (Request $request) {
    $union_name = $request->union_name;

    if($union_name){
        return TenderList::where('union_name',$union_name)->orderBy('id','desc')->get();
    }else{
        return TenderList::orderBy('id','desc')->get();

    }
  });

Route::get('get/single/tender/{id}', function (Request $request,$id) {

        return TenderList::find($id);

  });


  Route::apiResource('tander_invoices', TanderInvoiceController::class);

Route::get('tender/payment/{tender_id}', [TanderInvoiceController::class,'tanderDepositAmount']);




Route::get('citizen/information/nid/extanal', [CitizenInformationController::class,'citizeninformationNIDExtanal']);

Route::post('citizen/information/nid', [CitizenInformationController::class,'citizeninformationNID']);
Route::post('citizen/information/brn', [CitizenInformationController::class,'citizeninformationBRN']);



Route::post('register', [authController::class,'register']);
Route::get('get/roles',[authController::class,'getRoles']);

Route::get('set/notification',[NotificationsController::class,'notifications']);

Route::get('get/users/list',[RoleController::class,'index']);
Route::get('get/users/delete/{id}',[RoleController::class,'deleteuser']);

Route::get('update/users/{id}',[RoleController::class,'getuser']);
Route::post('update/users',[RoleController::class,'updateuser']);







Route::get('sonod/fee/list',[SonodnamelistController::class,'feeList']);

Route::get('get/sonodname/list',[SonodnamelistController::class,'index']);
Route::get('get/sonodname/delete/{id}',[SonodnamelistController::class,'deletesonodname']);

Route::get('update/sonodname/{id}',[SonodnamelistController::class,'getsonodname']);
Route::post('update/sonodname',[SonodnamelistController::class,'updatesonodname']);

Route::post('sonod/fee/setup',[SonodnamelistController::class,'updatesonodnameFee']);



Route::get('get/union/list',[UniouninfoController::class,'index']);
Route::get('get/union/delete/{id}',[UniouninfoController::class,'deleteunion']);

Route::get('update/union/{id}',[UniouninfoController::class,'getunion']);
// Route::post('update/union',[UniouninfoController::class,'updateunion']);
Route::post('union/info',[UniouninfoController::class, 'unionInfo']);
Route::post('unionprofile/submit',[UniouninfoController::class, 'unionInfoUpdate']);
Route::post('payment/update',[UniouninfoController::class, 'paymentUpdate']);



Route::get('get/sonod/count',[SonodnamelistController::class,'sonodCount']);
Route::post('prottoyon/update/{id}',[SonodController::class,'prottonupdate']);


Route::get('sonod/verify/get',[SonodController::class,'verifysonodId']);
Route::get('sonod/list',[SonodController::class,'index']);

Route::post('role/assign',[authController::class,'roleAssign']);

Route::get('sonod/single/{id}',[SonodController::class, 'singlesonod']);

Route::post('sonod/update',[SonodController::class, 'sonod_update']);

Route::get('sonod/delete/{id}',[SonodController::class, 'sonod_delete']);
Route::post('sonod/sec/approve/{id}',[SonodController::class, 'sec_sonod_action']);
Route::get('sonod/pay/{id}',[SonodController::class, 'sonod_pay']);
Route::post('sonod/cancel/{id}',[SonodController::class, 'cancelsonod']);
Route::get('sonod/{action}/{id}',[SonodController::class, 'sonod_action']);


Route::get('sonod/sonod_Id',[SonodController::class, 'sonod_id']);
Route::post('sonod/search',[SonodController::class, 'sonod_search']);

Route::post('/ipn',[PaymentController::class ,'ipn']);
Route::post('/re/call/ipn',[PaymentController::class ,'ReCallIpn']);
Route::post('/check/payments/ipn',[PaymentController::class ,'AkpayPaymentCheck']);

Route::get('akpay',[SonodController::class, 'akpay']);


Route::post('contact',[UniouninfoController::class, 'contact']);

//////
// Dashboard all counting and chart



Route::get('get/prepaid/sonod',[SonodController::class, 'preapidSonod']);


Route::get('sonodcountall',[SonodController::class, 'sonodcountall']);
Route::get('sum/amount',[SonodController::class, 'totlaAmount']);
Route::get('count/sonod/{status}',[SonodController::class, 'counting']);
Route::post('visitorcreate',[VisitorController::class, 'visitorcreate']);
Route::get('visitorcount',[VisitorController::class, 'visitorCount']);



//Category

Route::get('get/category/list',[BlogCategoryController::class,'index']);
Route::get('get/category/delete/{id}',[BlogCategoryController::class,'deletecategory']);
Route::get('update/category/{id}',[BlogCategoryController::class,'getcategory']);
Route::post('update/category',[BlogCategoryController::class,'updatecategory']);


//blogs

Route::get('get/blog/list',[blogController::class,'index']);
Route::get('get/blog/delete/{id}',[blogController::class,'deleteblog']);
Route::get('update/blog/{id}',[blogController::class,'getblog']);
Route::post('update/blog',[blogController::class,'updateblog']);


Route::get('reject/{id}',[ActionLogController::class,'rejectreason']);

Route::post('vattax/get',[CharageController::class,'index']);
Route::post('vattax/submit',[CharageController::class,'store']);



/// Citizen

Route::get('citizen/list',[CitizenController::class,'index']);
Route::get('citizen/show/{id}',[CitizenController::class,'show']);
Route::get('citizen/delete/{id}',[CitizenController::class,'destroy']);
Route::post('citizen/submit',[CitizenController::class,'store']);


/// Holding Tax





Route::get('holding/bokeya/list',[HoldingBokeyaController::class,'index']);

Route::post('holding/bokeya/action',[HoldingtaxController::class,'holding_tax_pay']);


Route::post('get/holding/tax',[HoldingBokeyaController::class,'holdingTaxPending']);


Route::post('holding/bokeya/edit/{id}',[HoldingBokeyaController::class,'holdingTaxEdit']);




Route::get('holding/tax/list',[HoldingtaxController::class,'index']);
Route::get('holding/tax/show/{id}',[HoldingtaxController::class,'show']);
Route::get('holding/tax/delete/{id}',[HoldingtaxController::class,'destroy']);
Route::post('holding/tax/submit',[HoldingtaxController::class,'store']);

Route::post('holding/tax/search',[HoldingtaxController::class,'holdingSearch']);

Route::get('payment/report/search',[PaymentController::class,'Search']);
Route::post('payment/report/search',[PaymentController::class,'Search']);



Route::get('payment/ekpay/report/search',[PaymentController::class,'SearchByAll']);


// Route::post('online/payment/report/search',[PaymentController::class,'onlinePaymentSearch']);




Route::get('cash/expenditure',[ExpenditureController::class,'index']);
Route::post('cash/expenditure',[ExpenditureController::class,'store']);


Route::get('niddob/verify',[SonodController::class,'niddob']);







// INSERT INTO `tenders` (`id`, `tender_id`, `dorId`, `nidNo`, `nidDate`, `applicant_orgName`, `applicant_org_fatherName`, `vill`, `postoffice`, `thana`, `distric`, `mobile`, `DorAmount`, `DorAmountText`, `depositAmount`, `bank_draft_image`, `deposit_details`, `status`, `payment_status`, `created_at`, `updated_at`) VALUES

// (NULL, '4', '120001', '', '', 'মোঃ সেলিম রানা', 'মোঃ আজিজার রহমান', 'পাগলীডাঙ্গী', 'বাংলাবান্ধা', 'তেতুলিয়া', 'পঞ্চগড়', '', '906000', 'নয় লক্ষ ছয় হাজার টাকা মাত্র', '100000', '', NULL, NULL, 'Paid', '2023-07-10 16:24:31', '2023-07-10 16:26:21'),

// (NULL, '4', '120002', '', '', 'মোঃ তাহিরুল ইসলাম', 'মোঃ তবিবর রহমান', 'দিঘলগাও', 'সিপাইপাড়া', 'তেতুলিয়া', 'পঞ্চগড়', '', '908000', 'নয় লক্ষ আট  হাজার টাকা মাত্র', '100000', '', NULL, NULL, 'Paid', '2023-07-10 16:24:31', '2023-07-10 16:26:21'),

// (NULL, '4', '120003', '', '', 'মোঃ নুরুল ইসলাম', 'মোঃ শরিফ উদ্দীন', 'বাইনগজ', 'সিপাইপাড়া', 'তেতুলিয়া', 'পঞ্চগড়', '', '907000', 'নয় লক্ষ সাত হাজার টাকা মাত্র', '100000', '', NULL, NULL, 'Paid', '2023-07-10 16:24:31', '2023-07-10 16:26:21'),

// (NULL, '4', '120004', '', '', 'মোঃ এরশাদ আলী', 'মোঃ হামিদুল ইসলাম', 'পাগলীডাঙ্গী', 'বাংলাবান্ধা', 'তেতুলিয়া', 'পঞ্চগড়', '', '910000', 'নয় লক্ষ দশ হাজার টাকা মাত্র', '100000', '', NULL, NULL, 'Paid', '2023-07-10 16:24:31', '2023-07-10 16:26:21'),

// (NULL, '4', '120005', '', '', 'মোঃ আয়নাল হক', 'আঃ জলিল', 'হুলাসুজোত', 'সিপাইপাড়া', 'তেতুলিয়া', 'পঞ্চগড়', '', '905000', 'নয় লক্ষ পাঁচ হাজার টাকা মাত্র', '100000', '', NULL, NULL, 'Paid', '2023-07-10 16:24:31', '2023-07-10 16:26:21'),

// (NULL, '4', '120006', '', '', 'মোঃ সাইফুল ইসলাম', 'মৃত. কফিজদ্দীন', 'উকিলজোত', 'সিপাইপাড়া', 'তেতুলিয়া', 'পঞ্চগড়', '', '904000', 'নয় লক্ষ পাঁচ হাজার টাকা মাত্র', '100000', '', NULL, NULL, 'Paid', '2023-07-10 16:24:31', '2023-07-10 16:26:21');


