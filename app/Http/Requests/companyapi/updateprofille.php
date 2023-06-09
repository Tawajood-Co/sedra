<?php

namespace App\Http\Requests\companyapi;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Traits\response;
use Auth;

class updateprofille extends FormRequest
{

    use response;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        $company_id=Auth::guard('company_api')->user()->id;
        return [
            'name'                        => 'required|unique:companies,name,'.$company_id,
            'phone'                       => 'required|unique:companies,phone,'.$company_id,
            //'account_number'              => 'required|unique:company_bank_accounts',
            'bank_name'                   => 'required',
            'email'                       =>  'required|unique:companies,email,'.$company_id,
            'country_code'                => 'required',
        ];
    }

    public function failedValidation( Validator $validator )
    {
        throw new HttpResponseException($this->response(false,$validator->messages()->first(),null,422));
    }

}
