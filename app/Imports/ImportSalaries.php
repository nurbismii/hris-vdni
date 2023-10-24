<?php

namespace App\Imports;

use App\Models\salary;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Ramsey\Uuid\Uuid;

class ImportSalaries implements ToCollection, WithHeadingRow, WithValidation
{
    public function collection(Collection $collection)
    {
        $datas = [];
        foreach ($collection as $collect) {
            $datas[] = [
                'id' => Uuid::uuid4()->getHex(),
                'employee_id' => $collect['nik'],
                'durasi_sp' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['durasi_sp']))) ?? null,
                'status_gaji' => $collect['status_gaji'],
                'jumlah_hari_kerja' => $collect['jumlah_hari_kerja'],
                'jumlah_hour_machine' => $collect['jumlah_hour_machine'],
                'gaji_pokok' => $collect['gaji_pokok'],
                'tunjangan_umum' => $collect['tunjangan_umum'],
                'tunjangan_pengawas' => $collect['tunjangan_pengawas'],
                'tunjangan_transport' => $collect['tunjangan_transport_pulsa'],
                'tunjangan_mk' => $collect['tunjangan_masa_kerja'],
                'tunjangan_koefisien' => $collect['tunjangan_koefisien_jabatan'],
                'ot' => $collect['overtime'],
                'hm' => $collect['hour_machine'],
                'rapel' => $collect['rapel'],
                'insentif' => $collect['insentif'],
                'tunjangan_lap' => $collect['tunjangan_lap'],
                'bonus' => $collect['bonus'],
                'jht' => $collect['bpjs_tk_jht'],
                'jp' => $collect['bpjs_tk_jp'],
                'bpjs_kesehatan' => $collect['bpjs_kesehatan'],
                'unpaid_leave' => $collect['deduction_unpaid_leave'],
                'deduction' => $collect['deduction'],
                'total_diterima' => $collect['total_diterima'],
                'account_number' => $collect['bank_number'],
                'bank' => $collect['bank_name'],
                'mulai_periode' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['mulai_periode']))),
                'akhir_periode' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['akhir_periode']))),
                'deduction_pph21' => $collect['deduction_pph21'],
                'thr' => $collect['thr'],
                'note' => $collect['note'],
                'created_by' => Auth::user()->nik_karyawan
            ];
        }

        foreach (array_chunk($datas, 1000) as $chunk) {
            salary::insert($chunk);
        }
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
            'nik.required' => 'NIK must be filled'
        ];
    }
}
