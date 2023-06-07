<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Setting;
use App\Traits\{response,fileTrait};



class SettingController extends Controller
{
    //
    use response;
    public function update_lang(Request $request){
        $company=Auth::guard('company_api')->user();
        $company->update([
          'lang'=>$request->header('lang')
        ]);
      return $this->response(true,'lang updated successfuly');
    }


    public function update_notify(Request $request){
        $company=Auth::guard('company_api')->user();
        $company->update([
            'notify'=>$request->notify
          ]);
          return $this->response(true,'notify updated successfuly');

    }



   public function get_aboutus(Request $request){
      $setting= Setting::first();
      $about_us=$setting->about_us;
      $data['data']['about_us']=$about_us;
      return $this->response(true,'get about us success',$data);
   }


   public function get_terms(Request $request){
        $setting= Setting::first();
        $terms=$setting->terms;
        $data['data']['terms']=$terms;
        return $this->response(true,'get about us success',$data);
   }

}
