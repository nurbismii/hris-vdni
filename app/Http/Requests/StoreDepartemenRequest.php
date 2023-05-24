<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartemenRequest extends FormRequest
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
            'departemen' => 'required',
            'kepala_dept' => 'required',
            'status_pengeluaran' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'departemen' => 'Departemen',
            'kepala_dept' => 'Kepala Departemen',
            'status_pengeluaran' => 'Status Pengeluaran'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi'
        ];
    }
}
