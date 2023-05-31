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
             return response()->json(['message' => 'Your Branch username or password maybe incorrect, please try agian'], 401);
         }
         return $this->response(true,__('response.login'));
    }
}
