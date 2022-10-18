<?php

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
use App\Http\Controllers\UniouninfoController;
use App\Http\Controllers\ExpenditureController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\HoldingBokeyaController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\SonodnamelistController;
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



// country api
Route::get('/getdivisions', [countryApiController::class,'getdivisions']);
Route::get('/getdistrict', [countryApiController::class,'getdistrict']);
Route::get('/getthana', [countryApiController::class,'getthana']);
Route::get('/getunioun', [countryApiController::class,'getunioun']);
Route::get('/gotoUnion', [countryApiController::class,'gotoUnion']);




Route::post('unionCreate', [UniouninfoController::class,'unionCreate']);



Route::post('register', [authController::class,'register']);
Route::get('get/roles',[authController::class,'getRoles']);

Route::get('set/notification',[NotificationsController::class,'notifications']);

Route::get('get/users/list',[RoleController::class,'index']);
Route::get('get/users/delete/{id}',[RoleController::class,'deleteuser']);

Route::get('update/users/{id}',[RoleController::class,'getuser']);
Route::post('update/users',[RoleController::class,'updateuser']);





Route::get('get/sonodname/list',[SonodnamelistController::class,'index']);
Route::get('get/sonodname/delete/{id}',[SonodnamelistController::class,'deletesonodname']);

Route::get('update/sonodname/{id}',[SonodnamelistController::class,'getsonodname']);
Route::post('update/sonodname',[SonodnamelistController::class,'updatesonodname']);



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
Route::post('sonod/submit',[SonodController::class, 'sonod_submit']);
Route::post('sonod/update',[SonodController::class, 'sonod_update']);

Route::get('sonod/delete/{id}',[SonodController::class, 'sonod_delete']);
Route::post('sonod/sec/approve/{id}',[SonodController::class, 'sec_sonod_action']);
Route::get('sonod/pay/{id}',[SonodController::class, 'sonod_pay']);
Route::post('sonod/cancel/{id}',[SonodController::class, 'cancelsonod']);
Route::get('sonod/{action}/{id}',[SonodController::class, 'sonod_action']);


Route::get('sonod/sonod_Id',[SonodController::class, 'sonod_id']);
Route::post('sonod/search',[SonodController::class, 'sonod_search']);



Route::get('akpay',[SonodController::class, 'akpay']);


Route::post('contact',[UniouninfoController::class, 'contact']);

//////
// Dashboard all counting and chart



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

Route::get('holding/tax/list',[HoldingtaxController::class,'index']);
Route::get('holding/tax/show/{id}',[HoldingtaxController::class,'show']);
Route::get('holding/tax/delete/{id}',[HoldingtaxController::class,'destroy']);
Route::post('holding/tax/submit',[HoldingtaxController::class,'store']);

Route::post('holding/tax/search',[HoldingtaxController::class,'holdingSearch']);

Route::post('report/search',[PaymentController::class,'Search']);




Route::get('cash/expenditure',[ExpenditureController::class,'index']);
Route::post('cash/expenditure',[ExpenditureController::class,'store']);


Route::get('niddob/verify',[SonodController::class,'niddob']);
