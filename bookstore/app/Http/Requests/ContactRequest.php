<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/(0)[0-9]/', 'not_regex:/[a-z]/'],
            'title' => 'required|string|min:3|max:100',
            'content' => 'required|string|min:3|max:1000',
        ];
    }
}
