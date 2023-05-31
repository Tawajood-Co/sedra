<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\companyregister;
use App\Models\{Company,CompanyBankAccount};
use App\Traits\{response,fileTrait};
use Auth;

class AuthController extends Controller
{
    //
    use response,fileTrait;
    public function register(companyregister $request){
       $logo=$this->MoveImage($request->logo,'uploads/companies/logo');
       $lang=$request->header('lang');
       $company=Company::create([
             'name'           =>$request->name,
             'email'          =>$request->email,
             'phone'          =>$request->phone,
             'country_code'   =>$request->country_code,
             'logo'           =>$request->logo,
             'password'       =>$request->password,
             'lang'           =>$lang
        ]);
        $CompanyBankAccount=CompanyBankAccount::create([
            'name'              =>$request->bank_name,
            'account_number'    =>$request->account_number,
            'company_id'        =>$company->id
        ]);
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
}
