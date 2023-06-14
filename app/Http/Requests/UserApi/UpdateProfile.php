<?php

namespace App\Http\Requests\UserApi;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use App\Traits\response;
use Auth;


class UpdateProfile extends FormRequest
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
            'phone'          =>'required',
            'country_code'   =>'required',
            'passport'       =>'required',
            'name'           =>'required|unique:users,name,'.$this->user->id,

        ];
    }
}
