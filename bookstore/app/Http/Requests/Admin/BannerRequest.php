<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            case 'update':
                $rules = [
                    'name' => 'required|string|min:3|max:20',
                    'thumb' => 'nullable|mimes:jpeg,png,jpg,gif',
                    'description' => 'required|string|min:3|max:20',
                    'status' => 'required|boolean',
                ];
                break;
            default:
                $rules += [
                    'name' => 'required|string|min:3|max:20',
                    'thumb' => 'required|mimes:jpeg,png,jpg,gif',
                    'description' => 'required|string|min:3|max:20',
                    'status' => 'required|boolean',
                ];
                break;
        }
        return $rules;
    }
}
