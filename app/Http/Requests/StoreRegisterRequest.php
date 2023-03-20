<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'employee_id' => 'required|unique,employee_id',
            'email' => 'required',
            'password' => 'required',
            'status' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'employee_id' => 'NIK',
            'email' => 'Email must be filled',
            'password' => 'Password must be filled',
            'status' => 'Status must be filled',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute must be filled',
            'min' => ':attribute',
            'unique' => ':attribute existing'
        ];
    }
}
