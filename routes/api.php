<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\AuthController;
use App\Http\Controllers\Api\User\{BarcodeController,OmraVisaController};
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
     });
     Route::controller(BarcodeController::class)->group(function(){
        Route::post('store/qrcode','store');
     });

      Route::controller(OmraVisaController::class)->group(function(){
        Route::post('store/omra','store');
     });
});

