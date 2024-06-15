<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'rate' => 'required',
            'content' => 'required|min:3|max:255',
            'product_id' => 'required',
        ];
    }

//    public function messages()
//    {
//        return [
//            'content' => 'Nội dụng đánh giá'
//        ];
//    }

    public function attributes()
    {
        return [
          'content' => 'Nội dụng đánh giá',
        ];
    }
}
