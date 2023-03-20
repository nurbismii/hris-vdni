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
            'employee_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'status' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'employee_id' => 'NIK',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'status' => 'Status',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute must be filled',
            'min' => ':attribute',
        ];
    }
}
