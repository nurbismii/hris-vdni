<?php

namespace App\Exports;

use App\Models\employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return employee::select('nik', 'no_sk_pkwtt', 'nama_karyawan', 'nama_ibu_kandung', 'agama', 'no_ktp', 'no_kk', 'jenis_kelamin', 'status_perkawinan', 'status_karyawan', 'tgl_resign', 'no_telp', 'tgl_lahir', 'area_kerja', 'golongan_darah', 'foto_karyawan', 'entry_date', 'npwp', 'bpjs_kesehatan', 'bpjs_tk', 'vaksin', 'jam_kerja', 'status_resign')->take(0)->get();
    }

    public function headings(): array
    {
        return array(
            'NIK', 'NO_SK_PKWTT', 'NAMA_KARYAWAN', 'NAMA_IBU_KANDUNG', 'AGAMA', 'NO_KTP', 'NO_KK', 'JENIS_KELAMIN', 'STATUS_PERKAWINAN', 'STATUS_KARYAWAN', 'TGL_RESIGN', 'NO_TELP', 'TGL_LAHIR', 'AREA_KERJA', 'GOLONGAN_DARAH', 'FOTO_KARYAWAN', 'ENTRY_DATE', 'NPWP', 'BPJS_KESEHATAN', 'BPJS_TK', 'VAKSIN', 'JAM_KERJA', 'STATUS_RESIGN'
        );
    }
}
