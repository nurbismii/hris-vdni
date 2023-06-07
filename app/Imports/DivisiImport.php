<?php

namespace App\Imports;

use App\Models\Divisi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DivisiImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $collection)
    {
        $datas = array();
        foreach ($collection as $collect) {
            $datas[] = array(
                'departemen_id' => $collect['departemen_id'],
                'nik_karyawan' => $collect['nik_karyawan'],
                'nama_divisi' => $collect['nama_divisi'],
                'jabatan' => $collect['jabatan']
            );
        }
        foreach (array_chunk($datas, 1000) as $chunk) {
            Divisi::insert($chunk);
        }
    }

    public function rules(): array
    {
        return [
            
        ];
    }
}
