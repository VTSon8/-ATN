<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DiscountCodeRequest extends FormRequest
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
            'code' => [
                'required',
                'string',
                'min:3',
                'max:10'
            ]
        ];
    }

    public function messages()
    {
        return [
            'code.required' => trans('messages.code_required')
        ];
    }

    public function attributes()
    {
        return [
          'code' => trans('messages.code'),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json(422, [
                    'message' => 'error validation.',
                    'errors' => $validator->errors()->toArray()
                ]
            )
        );
    }
}
