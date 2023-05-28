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
    public function Register(Request $request){
        $lang=$request->header('lang');
        $validator =Validator::make($request->all(), [
            'name'                  => 'required|unique:users',
            'password'              => 'required|min:6|max:50|confirmed',
            'password_confirmation' => 'required|max:50|min:6',
            'phone'                 => 'required|unique:users',
            'passport'              => 'required|unique:users',
            'passport_img'          => 'required',
            'country_code'          => 'required'
          ]);
          if ($validator->fails()) {
            return response()->json([
                'message'=>$validator->messages()->first()
            ],403);
           }
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

         $credentials = request(['phone', 'password']);
         if (!$token = auth()->guard('user_api')->attempt($credentials)) {
             return response()->json(['message' => 'Your Branch username or password maybe incorrect, please try agian'], 401);
         }
         return $this->response(true,__('response.login'));
    }
}
