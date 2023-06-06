<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class SettingController extends Controller
{
    //
    public function update_lang(Request $request){
        $company=Auth::guard('company_api')->user();
        $company->update([
          'lang'=>$request->header('lang')
        ]);

    }


    public function update_notify(Request $request){
        $company=Auth::guard('company_api')->user();
        $company->update([
            'notify'=>$request->lang
          ]);
    }


}
