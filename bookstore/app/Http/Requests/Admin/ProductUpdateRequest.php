<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
        $arr = explode('@', $this->route()->getActionName());
        $method = $arr[1];
        $rules = [];
        switch ($method) {
            case 'updateProductQuantity':
                $rules = [
                    'number' => 'required|integer|digits_between:1,3',
                ];
                break;
            case 'updateStatus':
                $rules = [
                    'status' => 'required|boolean',
                ];
                break;
            case 'update':
                $rules = [
                    'name' => 'required|string',
                    'category_id' => 'required',
                    'thumb' => 'nullable|mimes:jpeg,png,jpg,gif',
                    'images.*' => 'nullable|mimes:jpg,png,jpeg,gif,svg',
                    'description' => 'required|string',
                    'detail' => 'required|string',
                    'supplier_id' => 'required',
                    'sale' => 'nullable|numeric|between:0,100',
                    'original_price' => 'required',
                    'selling_price' => 'required|lt:original_price',
                    'author' => 'nullable|string',
                    'lang'=> 'nullable|string',
                    'translator'=> 'nullable|string',
                    'imprint'=> 'nullable|string',
                    'publishing_year' => 'nullable|numeric',
                    'weight' => 'nullable|numeric',
                    'size' => 'nullable|string',
                    'number_of_pages' => 'nullable|numeric',
                    'form' => 'numeric',
                    'status' => 'required',
                ];
                break;
            default:
                $rules = [
                    'name' => 'required|string',
                    'category_id' => 'required',
                    'thumb' => 'required|mimes:jpeg,png,jpg,gif',
                    'images.*' => 'required|mimes:jpg,png,jpeg,gif,svg',
                    'description' => 'required|string',
                    'detail' => 'required|string',
                    'supplier_id' => 'required',
                    'sale' => 'nullable|numeric|between:0,100',
//            'number' => 'required',
                    'original_price' => 'required',
                    'selling_price' => 'required|lt:original_price',
                    'author' => 'nullable|string',
                    'lang'=> 'nullable|string',
                    'translator'=> 'nullable|string',
                    'imprint'=> 'nullable|string',
                    'publishing_year' => 'nullable|numeric',
                    'weight' => 'nullable|numeric',
                    'size' => 'nullable|string',
                    'number_of_pages' => 'nullable|numeric',
                    'form' => 'numeric',
                    'status' => 'required',
                ];
                break;
        }
        return $rules;
    }


    public function messages()
    {
        return [
            'sale.between' => 'Giá trị khuyến mãi không được vượt quá 100%.',
            'sale.numeric' => 'Giá trị khuyến mãi phải là số',
            'selling_price.lt' => 'Giá khuyến mãi không được lớn hơn giá gốc',
        ];
    }
}
