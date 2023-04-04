<?php

namespace App\Exports;

use App\Models\salary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportSalaries implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return salary::select(
            'employee_id',
            'departemen',
            'divisi',
            'posisi',
            'durasi_sp',
            'status_gaji',
            'jumlah_hari_kerja',
            'jumlah_hour_machine',
            'gaji_pokok',
            'tunjangan_umum',
            'tunjangan_pengawas',
            'tunjangan_transport',
            'tunjangan_mk',
            'tunjangan_koefisien',
            'ot',
            'hm',
            'rapel',
            'insentif',
            'tunjangan_lap',
            'bonus',
            'jht',
            'jp',
            'bpjs_kesehatan',
            'unpaid_leave',
            'deduction',
            'total_diterima',
            'account_number',
            'bank',
            'mulai_periode',
            'akhir_periode',
            'deduction_pph21',
            'thr',
            'note'
        )->take(0)->get();
    }

    public function headings(): array
    {
        return [
            'NIK',
            'DEPARTEMEN',
            'DIVISI',
            'POSISI',
            'DURASI_SP',
            'STATUS_GAJI',
            'JUMLAH_HARI_KERJA',
            'JUMLAH_HOUR_MACHINE',
            'GAJI_POKOK',
            'TUNJANGAN_UMUM',
            'TUNJANGAN_PENGAWAS',
            'TUNJANGAN_TRANSPORT_PULSA',
            'TUNJANGAN_MASA_KERJA',
            'TUNJANGAN_KOEFISIEN_JABATAN',
            'OVERTIME',
            'HOUR_MACHINE',
            'RAPEL',
            'INSENTIF',
            'TUNJANGAN_LAP',
            'BONUS',
            'BPJS_TK_JHT',
            'BPJS_TK_JP',
            'BPJS_KESEHATAN',
            'DEDUCTION_UNPAID_LEAVE',
            'DEDUCTION',
            'TOTAL_DITERIMA',
            'BANK_NUMBER',
            'BANK_NAME',
            'MULAI_PERIODE',
            'AKHIR_PERIODE',
            'DEDUCTION_PPH21',
            'THR',
            'NOTE'
        ];
    }
}
