<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Traits\{response,fileTrait};
use Auth;

class SettingController extends Controller
{
    use response;
    public function update_lang(Request $request){
        $company=Auth::guard('user_api')->user();
        $company->update([
          'lang'=>$request->header('lang')
        ]);
      return $this->response(true,__('response.update_lang'));
    }


    public function update_notify(Request $request){
        $company=Auth::guard('user_api')->user();
        $company->update([
            'notify'=>$request->notify
          ]);
          return $this->response(true,__('response.update_notify'));
    }


    public function get_aboutus(Request $request){
        $setting= Setting::first();
        $about_us=$setting->about_us;
        $data['about_us']=$about_us;
        return $this->response(true,'get about us success',$data);
     }


     public function get_terms(Request $request){
          $setting= Setting::first();
          $terms=$setting->terms;
          $data['terms']=$terms;
          return $this->response(true,'get about us success',$data);
     }


    public function contactus(){
        $contact_us=Setting::select('email_contact','phone_contact')->first();
        $data['contact_us']=$contact_us;
        return $this->response(true,'get contact success',$data);
    }

}
