<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\companyapi\companyregister;
use App\Models\{Company,CompanyBankAccount};
use App\Traits\{response,fileTrait};
use Validator;
use Auth;

class AuthController extends Controller
{
    //
    use response,fileTrait;
    public function register(companyregister $request){
        dd($request->logo);
       $logo=$this->MoveImage($request->logo,'uploads/companies/logo');
       $lang=$request->header('lang');
       $company=Company::create([
             'name'           =>$request->name,
             'email'          =>$request->email,
             'phone'          =>$request->phone,
             'country_code'   =>$request->country_code,
             'logo'           =>$logo,
             'password'       =>$request->password,
             'lang'           =>$lang
        ]);
        foreach($request->bank_name as $key=>$bank){
            $CompanyBankAccount=CompanyBankAccount::create([
                'name'              =>$bank,
                'account_number'    =>$request->account_number[$key],
                'company_id'        =>$company->id
            ]);
        }

        $token=auth('company_api')->login($company);
        $data['token']=$token;

        return $this->response(true,'register success',$data);
    }

    public function login(Request $request){
        $credentials = request(['phone','password']);

        if (!$token = auth()->guard('company_api')->attempt($credentials)) {
            return response()->json(['message' => 'Your company phone or password maybe incorrect, please try agian'], 401);
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
           $company=Company::where('phone',$request->phone,'country_id',$request->country_id)->first();
           if($company==null)
           return $this->response(false ,'this phone not avilable',null,409);

           //here create otp
            $otp=1234;
           // here snd sms

           $company->update([
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
          $company=company::where('phone',$request->phone)->where('otp',$request->otp)->first();
          if($company==null)
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

           $company=company::where('phone',$request->phone)->where('otp',$request->otp)->first();
           if($company==null)
           return $this->response(false,'otp is uncorrect',null,405);

           $company->update([
              'password'=>$request->password
           ]);

           return $this->response(true,'password updated sucessfuly');

    }


}
