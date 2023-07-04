<?php

namespace App\Http\Requests\companyapi;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Traits\response;

class companyregister extends FormRequest
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
    public function rules()
    {
        return [
            'name'                        => 'required|unique:companies',
            'password'                    => 'required|min:6|max:50',
            //'password_confirmation' => 'required|max:50|min:6',
            'phone'                       =>'required|unique:companies',
            'account_number'              => 'required|unique:company_bank_accounts',
            'bank_name'                   => 'required',
            'email'                       => 'required|unique:companies',
            'country_code'                => 'required',
            'logo'                        => 'required'
        ];
    }

    public function failedValidation( Validator $validator )
    {
        throw new HttpResponseException($this->response(false,$validator->messages()->first(),null,422));
    }

}
