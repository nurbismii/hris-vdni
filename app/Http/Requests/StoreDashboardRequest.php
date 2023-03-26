<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDashboardRequest extends FormRequest
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
            'title' => 'required|min:3|max:225',
            'subtitle' => 'max:225'
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'subtitle' => 'Subtitle',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute must be filled',
            'min' => ':attribute min 3 character',
            'max' => ':attriubute max 225 character',
        ];
    }
}
