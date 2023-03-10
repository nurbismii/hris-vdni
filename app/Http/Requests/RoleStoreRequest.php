<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'permission_role' => 'required',
            'status' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'permission_role' => 'The permissions role must be filled',
            'status' => 'The status must be filled'
        ];
    }

    public function messages()
    {
        return [
            'permission_role' => ':attribute',
            'status' => ':attribute'
        ];
    }
}
