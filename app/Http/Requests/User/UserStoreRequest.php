<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'employee_id' => 'required|unique:employees,employee_id',
            'name' => 'required',
            'email' => 'required|unique:employees,email',
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
            'unique' => ':attribute NIK has been registered',
            'required' => ':attribute must be filled',
        ];
    }
}
