<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGajiKaryawanRequest extends FormRequest
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
            'nik_karyawan' => 'required',
            'jumlah_hari_kerja' => 'required',
            'tunj_makan' => 'required',
            'gaji_pokok' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'nik_karyawan' => 'Nomor Induk Karyawan',
            'jumlah_hari_kerja' => 'Jumlah hari kerja',
            'tunj_makan' => 'Uang makan',
            'gaji_pokok' => 'Gaji pokok'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute wajib diisi'
        ];
    }
}
