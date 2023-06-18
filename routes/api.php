<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\AuthController;
use App\Http\Controllers\Api\User\{BarcodeController,OmraVisaController,
    CampaignController,SettingController,NotificationController
    ,ProfileController
  };
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
Route::middleware('lang')->group(function(){
    Route::controller(AuthController::class)->group(function(){
        Route::Post('register','register');
        Route::post('login','login');
        Route::post('checkphone','checkphone');
        Route::post('sendotp','sendotp');
     });


     Route::middleware('UserApiAuth')->group(function(){

        Route::controller(AuthController::class)->group(function(){
            Route::post('newpassword','updatepassword');
            Route::post('logout','logout');
        });


        Route::controller(BarcodeController::class)->group(function(){
            Route::post('store/qrcode','store');
        });

        Route::controller(OmraVisaController::class)->group(function(){
            Route::post('store/omra','store');
        });

        Route::controller(CampaignController::class)->group(function(){
            Route::Post('get/campaigns','get_campaigns');
            Route::get('campaign/show/{campaign_id?}','show');
            Route::post('book/compaign','book');
            Route::get('filter/campaign/{price?&rate?}','filtercampign');
            Route::get('my/campaigns','get_my_comapigns');
            Route::get('show/my/campaign/{campaign_id?}','show_my_campaign');
            Route::post('review/company','review_company');
            Route::get('get/company/reviews/{comapny_id?}','get_company_reviews');
        });


        Route::controller(SettingController::class)->group(function(){
            Route::get('/update/lang','update_lang');
            Route::post('update/notify','update_notify');
            Route::get('get/about_us','get_aboutus');
            Route::get('get/terms','get_terms');
            Route::get('get/contact','contactus');
        });


        Route::controller(NotificationController::class)->group(function(){
            Route::Post('/create/token','create_device_token');
        });


        Route::controller(ProfileController::class)->group(function(){
           Route::get('get/profile','index');
           Route::post('update/profile','update');
           Route::post('update/phone','updatephone');


        });

    });


});

