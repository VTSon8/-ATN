<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PostsRequest extends FormRequest
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
                    'title' => 'required|min:3|max:1000',
                    'description' => 'required|min:3|max:1000',
                    'content' => 'required',
                    'img' => 'nullable|mimes:jpeg,png,jpg,gif|nullable',
                    'status' => 'nullable',
                ];
                break;
            case 'updateStatus':
                $rules = [
                    'status' => 'required|integer',
                ];
                break;
            default:
                $rules += [
                    'title' => 'required|min:3|max:1000',
                    'description' => 'required|min:3|max:1000',
                    'content' => 'required|min:3',
                    'img' => 'required|mimes:jpeg,png,jpg,gif|nullable',
                    'status' => 'required',
                ];
                break;
        }
        return $rules;
    }
}
