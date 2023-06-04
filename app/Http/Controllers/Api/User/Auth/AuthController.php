<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Traits\response;
use Validator;

class AuthController extends Controller
{
    //
    use response;
    public function Register(UserRequest $request){
        $lang=$request->header('lang');
        $user=User::create([
            'name'=>$request->name,
            'password'=>$request->password,
            'phone'=>$request->phone,
            'passport'=>$request->passport,
            'passport_img'=>$request->passport_img,
            'country_code'=>$request->country_code,
            'lang'=>$lang
        ]);
       return $this->response(true,__('response.register'));
    }

    public function login(Request $request){

         $credentials = request(['phone','password']);
         if (!$token = auth()->guard('user_api')->attempt($credentials)) {
             return response()->json(['message' => 'Your User username or password maybe incorrect, please try agian'], 401);
         }
         $data['token']=$token;
         return $this->response(true,__('response.login'),$data);
    }


    public function checkphone(Request $request){
        $validator =Validator::make($request->all(), [
            'phone'       =>'required',
            'country_code'  =>'required'
          ]);
          if ($validator->fails()) {
           return response()->json([
               'message'=>$validator->messages()->first()
           ],403);
           }
           $user=User::where('phone',$request->phone,'country_id',$request->country_id)->first();
           if($user==null)
           return $this->response(false ,'this phone not avilable',null,409);

           //here create otp
            $otp=1234;
           // here snd sms

           $user->update([
              'otp'=>$otp
           ]);

           return $this->response(true,'check your phone and send otp');
    }


    public function sendotp(Request $request){
        $validator =Validator::make($request->all(), [
            'otp'                   =>'required',
            'phone'              => 'required',
          ]);
          if ($validator->fails()) {
           return response()->json([
               'message'=>$validator->messages()->first()
           ],403);
           }
          $user=User::where('phone',$request->phone)->where('otp',$request->otp)->first();
          if($user==null)
          return $this->response(false,'otp is uncorrect',null,405);

          return $this->response(true,'go to next request');
    }

    public function updatepassword(Request $request){
        $validator =Validator::make($request->all(), [
            'otp'                   =>'required',
            'password'              => 'required|min:6|max:50|confirmed',
            'password_confirmation' => 'required|max:50|min:6',
          ]);
          if ($validator->fails()) {
           return response()->json([
               'message'=>$validator->messages()->first()
           ],403);
           }

           $user=User::where('phone',$request->phone)->where('otp',$request->otp)->first();
           if($user==null)
           return $this->response(false,'otp is uncorrect',null,405);

           $user->update([
              'password'=>$request->password
           ]);

           return $this->response(true,'password updated sucessfuly');

    }



}
