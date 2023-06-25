<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\{response,fileTrait};
use Validator;
use Auth;
use Illuminate\Contracts\Validation\Rule;
use Hash;
class ProfileController extends Controller
{
    //
    use response,fileTrait;

    public function index(){
       $user=Auth::guard('user_api')->user();
       $data['profile_info']=User::find(1);
       return $this->response(true,'get user success',$data);
    }

    public function update(Request $request){

        $user=Auth::guard('user_api')->user();


           $validator =Validator::make($request->all(), [

                'country_code'   =>'required',
                'passport'       =>'required',
                'name'           =>'required|unique:users,name,'.$user->id,
                'phone'         =>'required|unique:users,phone,'.$user->id,

            ]);

            if ($validator->fails()) {
                    return response()->json([
                        'message'=>$validator->messages()->first()
                    ],403);
            }

            $passport_img=$user->passport_img;
            $img=$user->img;

            if($request->passport_img!=null){

                $passport_img=$this->MoveImage($request->passport_img,'uploads/users/passport_img');

            }

            if($request->img!=null){
                $img=$this->MoveImage($request->img,'uploads/users/imgs/');

            }

            $user->update([
                'name'           =>$request->name,
                'passport'       =>$request->passport,
                'passport_img'   =>$passport_img,
                'img'            =>$img
             ]);

            if($request->phone!=$user->phone){
                $user->otp=1234;
                $user->save();
                 return $this->response(true,'send otp');
            }else{
                 return $this->response(true,'user updated successfuly');
            }

    }


    public function updatephone(Request $request){

        $user=Auth::guard('user_api')->user();

        $validator =Validator::make($request->all(), [

            'otp'             =>'required',
            'country_code'    =>'required',
            'phone'           =>'required|unique:users,phone,'.$user->id,

        ]);

        if ($validator->fails()) {
                return response()->json([
                    'message'=>$validator->messages()->first()
                ],403);
        }


        if($request->otp==$request->otp){
            $user->update([
              'phone'           =>$request->phone,
              'country_code'    =>$request->country_code
            ]);

            return  $this->response(true,'phone updated successfuly');
        }else{
            return  $this->response(false,'wrong code try again later',null,403);
        }

    }


    public function update_password(Request $request){
        $validator =Validator::make($request->all(), [
            'old_password'          =>  'required',
            'password'              => 'required|min:6|max:50|confirmed',
            'password_confirmation' => 'required|max:50|min:6',
          ]);
          if ($validator->fails()) {
           return response()->json([
               'message'=>$validator->messages()->first()
           ],403);
           }
           $user=Auth::guard('user_api')->user();
           if(!Hash::check($request->old_password, $user->password))
           return $this->response(false, "The specified password does not match the old password");

           $user->update([
              'password'=>$request->password,
           ]);

           return $this->response(true,'password updated successfuly');

    }

}
