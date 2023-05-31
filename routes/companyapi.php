<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Company\{AuthController,CampainController};
use App\Http\Controllers\CountryController;
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

    Route::controller(CountryController::class)->group(function(){
       Route::get('getcountries','getcountries');
       Route::get('getcities/{country_id?}','getcities');
       Route::get('getprograms','getprograms');
    });

    Route::middleware('CompanyAuthApi')->group(function(){  //
        Route::controller(CampainController::class)->group(function(){
            Route::Post('store/campaign','store');
        });
    });
});

