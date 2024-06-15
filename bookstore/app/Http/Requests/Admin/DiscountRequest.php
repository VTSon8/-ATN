<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DiscountRequest extends FormRequest
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
            'code' => 'required|string|min:3|max:12',
            'discount' => 'required|integer',
            'limit_number' => 'required|integer',
            'expiration_date' => 'required|date',
            'payment_limit' => 'required|integer|digits_between:1,8',
            'description' => 'string|nullable',
            'status' => 'required',
        ];
    }
}
