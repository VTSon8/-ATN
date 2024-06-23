<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'name' => 'required|string|min:3',
            'phone' => 'required|max: 13',
            'address' => 'required|string|min:3|max:100',
            'lat_from' => 'required',
            'long_from' => 'required',
            'payment_type' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên người nhận',
            'email.required' => 'Bạn chưa nhập địa chỉ email',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'address' => 'Bạn chưa nhập địa chỉ giao hàng',
            'payment_type' => 'Bạn cần chọn phương thức thanh toán',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên người nhận hàng',
            'email' => 'Địa chỉ email',
            'phone' => 'Số điện thoại',
            'address' => 'Địa chỉ',
            'payment_type' => 'Phương thức thanh toán',
        ];
    }
}
