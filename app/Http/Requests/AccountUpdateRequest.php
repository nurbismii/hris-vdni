<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required',
            'name' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
            'name' => 'Name',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute must be filled'
        ];
    }
}
