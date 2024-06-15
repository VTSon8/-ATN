<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required|min:3|max:191',
            'category_id' => 'required|exists:categories,id',
            'thumb' => 'required|mimes:jpeg,png,jpg,gif',
            'images.*' => 'nullable|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'description' => 'required|string',
            'detail' => 'required|string|min:3',
            'supplier_id' => 'required|exists:suppliers,id',
            'number' => 'required|integer|digits_between:1,5',
            'sale' => 'nullable|integer|digits_between:1,3',
            'original_price' => 'required|digits_between:4,9',
            'selling_price' => 'numeric|max:' . $this->original_price . '|digits_between:4,9|nullable',
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
    }

    public function attributes()
    {
         return [
             'name' => 'tên sản phẩm',
             'thumb ' => 'ảnh đại diện sản phẩm',
             'images ' => 'ảnh sản phẩm',
             'category_id' => 'danh mục sản phẩm',
             'supplier_id' => 'nhà cung cấp',
             'sale' => 'khuyến mại theo %',
             'detail' => 'chi tiết sản phẩm',
             'original_price' => 'giá gốc',
             'selling_price' => 'giá khuyến mãi',
         ];
    }
}
