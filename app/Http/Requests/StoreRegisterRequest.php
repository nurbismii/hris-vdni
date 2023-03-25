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
            'employee_id' => 'required|unique:users,employee_id',
            'email' => 'required:unique:users,email',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
        ];
    }

    public function attributes()
    {
        return [
            'employee_id' => 'NIK',
            'email' => 'Email',
            'password' => 'Password',
            'password_confirm' => 'Password Confirmattion',
        ];
    }

    public function messages()
    {
        return [
            'unique' => ':attribute has been registered',
            'required' => ':attribute must be filled',
            'min' => ':attribute',
            'same' => ':attribute does not match'
        ];
    }
}
