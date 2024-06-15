<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
                    'name' => 'required|string|min:4|max:12',
                    'role_id' => 'required',
                    'email' => 'required|email',
                    'phone' => 'nullable|max:12',
                    'avatar' => 'nullable|mimes:jpeg,png,jpg,gif',
                    'status' => 'required|boolean',
                ];
                break;
            default:
                $rules = [
                    'name' => 'required|string|min:4|max:12',
                    'role_id' => 'required',
                    'email' => 'required|email',
                    'password' => 'required|string|min:6|max:14',
                    'status' => 'required|boolean',
                ];
                break;
        }
        return $rules;
    }
}
