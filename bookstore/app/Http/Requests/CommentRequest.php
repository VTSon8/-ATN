<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'content' => 'required|min:3|max:1000',
            'product_id' => 'required',
            'comment_id' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Vui lòng nhập nội dung',
            'content.min' => 'Vui lòng nhập tối thiểu 3 ký tự',
            'content.max' => 'Bình luận không quá 1000 ký tự',
        ];
    }
}
