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
            'email' => ['required', 'string', 'email'],
            'phone' => 'required|max: 13',
            'province_id' => 'required',
            'district_id' => 'required',
            'ward_id' => 'required',
            'from' => 'required',
            'address' => 'required|string|min:3|max:100',
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
            'from.required' => 'Bạn chọn địa chỉ giao hàng',
            'ward_id.required' => 'Bạn chọn địa chỉ giao hàng'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'tên người nhận hàng',
            'email' => 'địa chỉ email',
            'phone' => 'số điện thoại',
            'address' => 'địa chỉ',
        ];
    }


}
