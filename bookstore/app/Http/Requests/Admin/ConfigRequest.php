<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
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
            'longitude' => 'required',
            'latitude' => 'required',
            'km_prices.*.km' => 'required|max:2000',
            'km_prices.*.price_ship' => 'required|max:1000000'
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Vị trí cửa hàng',
            'km_prices.*.km' => 'Số km',
            'km_prices.*.price_ship' => 'Giá vận chuyển',
        ];
    }
}
