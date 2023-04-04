<?php

namespace App\Exports;

use App\Models\Contract;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContractExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Contract::select(
            'no_pkwt',
            'jenis_kelamin',
            'nik',
            'nama',
            'alamat',
            'no_ktp',
            'jabatan',
            'lama_kontrak',
            'status_pernikahan',
            'tanggal_mulai_kontrak',
            'tanggal_berakhir_kontrak',
            'gaji',
            'uang_makan',
            'hm',
            'tunjangan_jabatan',
            'keterangan_kontrak',
            'status'
        )->take(0)->get();
    }

    public function headings(): array
    {
        return [
            'NO_PKWT',
            'JENIS_KELAMIN',
            'NIK',
            'NAMA',
            'ALAMAT',
            'NO_KTP',
            'JABATAN',
            'LAMA_KONTRAK',
            'STATUS_PERNIKAHAN',
            'TANGGAL_MULAI_KONTRAK',
            'TANGGAL_BERAKHIR_KONTRAK',
            'GAJI',
            'UANG_MAKAN',
            'HM',
            'TUNJANGAN_JABATAN',
            'KETERANGAN_KONTRAK',
            'STATUS'
        ];
    }
}
