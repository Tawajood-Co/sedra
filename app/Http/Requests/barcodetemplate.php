<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Traits\response;


class barcodetemplate extends FormRequest
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
            'name'                  => 'required',
            'phone'                 => 'required',
            'passport'              => 'required',
            'passport_img'          => 'required',
            'country_code'          => 'required'
        ];
    }
    public function failedValidation( Validator $validator )
    {
        throw new HttpResponseException($this->response(false,$validator->messages()->first(),null,422));
    }
}
