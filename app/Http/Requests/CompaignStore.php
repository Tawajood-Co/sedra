<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Traits\response;

class CompaignStore extends FormRequest
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
            'name_ar'                     => 'required',
            'name_en'                     => 'required',
            'program'                     => 'required',
            'description_ar'              => 'required',
            'description_en'              => 'required',
            'img'                         => 'required',
            'single_price'                => 'required',
            'double_price'                => 'required',
            'country_id'                  => 'required',
            'city_id'                     => 'required',
            'persons_count'               => 'required',
            'admin_name'                  => 'required',
            'admin_phone'                 => 'required',
            'admin_country_code'          => 'required',
        ];
    }
    public function failedValidation( Validator $validator )
    {
        throw new HttpResponseException($this->response(false,$validator->messages()->first(),null,422));
    }
}
