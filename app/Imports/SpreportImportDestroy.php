<?php

namespace App\Imports;

use App\Models\SpReport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SpreportImportDestroy implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        SpReport::where('nik_karyawan', $row['nik'])->chunkById(500, function ($sp) {
            foreach ($sp as $row) {
                $row->delete();
            }
        });
    }

    public function rules(): array
    {
        return [
            'nik' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik.required' => 'NIK must be filled in',
        ];
    }
}
