<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class ChangePasswordRequest extends FormRequest
{
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
     * @return array
     */
    public function rules()
    {
        return [
            'password_old' => ['required', Rules\Password::defaults()],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required',  Rules\Password::defaults()],
        ];
    }

    public function messages()
    {
        return [
//            'password_old.required' => 'Mật hiện tại',
//            'password' => 'Mật khẩu mới',
//            'password_confirmation' => 'Xác thực mật khẩu',
        ];
    }

    public function attributes()
    {
        return [
            'password_old' => 'Mật hiện tại',
            'password' => 'Mật khẩu mới',
            'password_confirmation' => 'Xác thực mật khẩu',
        ];
    }
}
