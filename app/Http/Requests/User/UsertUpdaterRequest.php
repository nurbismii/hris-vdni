<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UsertUpdaterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'employee_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'status' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'employee_id' => 'NIK',
            'name' => 'Name',
            'email' => 'Email',
            'status' => 'Status',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute must be filled',
        ];
    }
}
