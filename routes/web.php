<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return 'optimize clear success';
});
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
    Route::get('',function (){
        return "لا حول ولا قوة الا بالله العلى العظيم";
    });
    Route::prefix('dashboard')->namespace('Dashboard')->middleware(['auth','web'])->name('dashboard.')->group(function () {
    });
});
