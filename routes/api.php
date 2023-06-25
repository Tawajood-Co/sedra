<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\AuthController;
use App\Http\Controllers\Api\User\{BarcodeController,OmraVisaController,
    CampaignController,SettingController,NotificationController
    ,ProfileController,ProductController,CartController,OrderController,WalletController
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

     Route::controller(ProductController::class)->group(function(){
        Route::get('get/products/{type?}','get_products');
        Route::get('get/product/{product_id?}','get_product');
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
            Route::post('report/company','create_report');
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
           Route::post('update/password','update_password');

        });


        Route::controller(CartController::class)->group(function(){
           Route::get('get/cart','get_cart');
           Route::post('add/to/cart','store_cart_item');
           Route::get('get/cart','get_cart');
           Route::get('increase/item/{product_id?}','increase_item');
           Route::get('decrease/item/{product_id?}','decrease_item');  //
           Route::get('remove/item/{product_id?}','remove_item');
        });


        Route::controller(OrderController::class)->group(function(){
            Route::post('create/order','store');
            Route::get('get/banks','get_banks');
            Route::post('bank/transfare','bank_transfare');
        });



        Route::controller(WalletController::class)->group(function(){
            Route::get('get/wallet','get_wallet');
            Route::post('charge/wallet','charge_wallet');
        });

    });


});

