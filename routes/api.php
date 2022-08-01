<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SonodController;
use  App\Http\Controllers\api\authController;
use App\Http\Controllers\UniouninfoController;
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
Route::post('register', [authController::class,'register']);
Route::get('get/roles',[authController::class,'getRoles']);



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
Route::post('profile/submit',[UniouninfoController::class, 'unionInfoUpdate']);
Route::post('payment/update',[UniouninfoController::class, 'paymentUpdate']);



Route::get('get/sonod/count',[SonodnamelistController::class,'sonodCount']);
Route::get('sonod/list',[SonodController::class,'index']);

Route::post('role/assign',[authController::class,'roleAssign']);

Route::get('sonod/single/{id}',[SonodController::class, 'singlesonod']);
Route::post('sonod/submit',[SonodController::class, 'sonod_submit']);

Route::get('sonod/delete/{id}',[SonodController::class, 'sonod_delete']);
Route::post('sonod/sec/approve/{id}',[SonodController::class, 'sec_sonod_action']);
Route::get('sonod/pay/{id}',[SonodController::class, 'sonod_pay']);
Route::get('sonod/{action}/{id}',[SonodController::class, 'sonod_action']);
Route::get('sonod/sonod_Id',[SonodController::class, 'sonod_id']);
Route::post('sonod/search',[SonodController::class, 'sonod_search']);



Route::get('akpay',[SonodController::class, 'akpay']);


Route::post('contact',[UniouninfoController::class, 'contact']);

//////
// Dashboard all counting and chart



Route::get('count/sonod/{status}',[SonodController::class, 'counting']);
