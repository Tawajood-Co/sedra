<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Traits\response;

class AuthController extends Controller
{
    //
    use response;
    public function Register(Request $request){
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
       return $this->response(true,'you create acount success');
    }
}
