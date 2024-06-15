<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email',
            'birthday' => 'nullable|date',
            'phone' => 'nullable|max:12',
            'avatar' => 'nullable|mimes:jpeg,png,jpg,gif',
            'address' => 'nullable|min:3|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên tài khoản',
            'email' => 'Địa chỉ email',
            'birthday' => 'Ngày sinh',
            'phone' => 'Số điện thoại',
            'avatar' => 'Ảnh đại điện',
            'address' => 'Địa chỉ',
        ];
    }
}
