<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\companyapi\updateprofille;
use App\Models\{Company,CompanyBankAccount,Setting,CompanyReview};
use Validator;
use Auth;
use Hash;
use App\Traits\{response,fileTrait};

class ProfileController extends Controller
{
    //
    use response,fileTrait;
    public function getprofile(){

        $companyid=Auth::guard('company_api')->user()->id;
        $company=Company::with('companyBankAccounts')->find($companyid);
        $data['company']=$company;
        return $this->response(true,'get company data success',$data);
    }

    public function changepassword(Request $request){

          // validation
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

           $company=Auth::guard('company_api')->user();

           if(!Hash::check($request->old_password, $company->password))
           return $this->response(false, "The specified password does not match the old password");

           $company->update([
              'password'=>$request->password,
           ]);

           return $this->response(true,'password updated successfuly');
    }

    public function updateprofile(updateprofille $request){
        $company=Auth::guard('company_api')->user();
        $company->update([
          'name'=>$request->name,
          'email'=>$request->email,
          'phone'=>$request->phone,
          'country_code'=>$request->country_code,
        ]);
        // update company bank acount
        $bankacounts=CompanyBankAccount::where('company_id',$company->id)->get();
        foreach($bankacounts as $bank){
            $bank->delete();
        }
        foreach($request->bank_name as $key=>$bank){
            $CompanyBankAccount=CompanyBankAccount::create([
                'name'              =>$bank,
                'account_number'    =>$request->account_number[$key],
                'company_id'        =>$company->id
            ]);
        }

        if($request->has('logo')){
            $logo=$this->MoveImage($request->logo,'uploads/companies/logo');
            $company->update([
              'logo'=>$logo
            ]);
        }


        return $this->response(true,'company updated succesfuly');
    }

    public function contactus(){
        $contact_us=Setting::select('email_contact','phone_contact')->first();
        $data['contact_us']=$contact_us;
        return $this->response(true,'get contact success',$data);
    }


    public function get_reviews(){

        $company=Auth::guard('company_api')->user();
        $reviews=CompanyReview::where('company_id',$company->id)->with('user',function($q){
            return $q->select('id','img','name')->get();
        })->get();
        $data['reviews']=$reviews;
        return $this->response(true,'get reviews success',$data);

    }


}
