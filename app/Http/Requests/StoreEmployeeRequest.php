<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
            'nik' => 'required',
            'no_ktp' => 'required',
            'name' => 'required',
            'company_name' => 'required',
            'date_of_birth' => 'required',
            'npwp' => 'required',
            'bpjs_ket' => 'required',
            'bpjs_tk' => 'required',
            'vaccine' => 'required',
            'entry_date' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'nik' => 'NIK',
            'no_ktp' => 'NO KTP',
            'name' => 'Name',
            'company_name' => 'Company Name',
            'date_of_birth' => 'Date of Birth',
            'npwp' => 'NPWP',
            'bpjs_ket' => 'BPJS Kesehatan',
            'bpjs_tk' => 'BPJS Ketenagakerjaan',
            'vaccine' => 'Vaccine',
            'entry_date' => 'Entry Date',
        ];
    }
}
