<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'                  => ['required|unique:users'],
            'password'              => ['required|min:6|max:50|confirmed'],
            'password_confirmation' => ['required|max:50|min:6'],
            'phone'                 => ['required|unique:users'],
            'passport'              => ['required|unique:users'],
            'passport_img'          => ['required'],
            'country_code'          => ['required']

        ];
    }
}
