<?php

namespace App\Http\Controllers\Api\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Interfaces\NotificationRepositoryinterface; 
use App\Models\User;
use App\Traits\{response,fileTrait};
use Validator;
use Auth;

class AuthController extends Controller
{
    //
    use response,fileTrait;

    private NotificationRepositoryinterface $NotificationRepository;
    public function __construct(NotificationRepositoryinterface $NotificationRepository)
    {
        $this->NotificationRepository = $NotificationRepository;
    }

    public function Register(UserRequest $request){
        $lang=$request->header('lang');

        $passport_img=$this->MoveImage($request->passport_img,'uploads/users/passport_img');
        $user=User::create([
            'name'=>$request->name,
            'password'=>$request->password,
            'phone'=>$request->phone,
            'passport'=>$request->passport,
            'passport_img'=>$passport_img,
            'country_code'=>$request->country_code,
            'lang'=>$lang
        ]);
        $user->otp=1234;
        $user->save;

        $token=auth('user_api')->login($user);
        $data['token']=$token;

        return $this->response(true,__('response.register'),$data);
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

    public function logout(Request $request){

         $this->NotificationRepository->delete_device_token('user',$request->device_token);
         Auth::guard('user_api')->logout();
         return response()->json([
             'status' => true,
             'message'=>'logout success',
         ]);
    }

}
