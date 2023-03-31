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
                'departemen' => $collect['departemen'],
                'divisi' => $collect['divisi'],
                'posisi' => $collect['posisi'],
                'durasi_sp' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($collect['durasi_sp'])),
                'status_gaji' => $collect['status'],
                'jumlah_hari_kerja' => $collect['jml_hari_kerja'],
                'jumlah_hour_machine' => $collect['jml_hour_machine'],
                'gaji_pokok' => $collect['gapok'],
                'tunjangan_umum' => $collect['tunj_um'],
                'tunjangan_pengawas' => $collect['tunj_pegawai'],
                'tunjangan_transport' => $collect['tunj_transport_pulsa'],
                'tunjangan_mk' => $collect['tunj_masa_kerja'],
                'tunjangan_koefisien' => $collect['tunj_koefisien_jabatan'],
                'ot' => $collect['overtime'],
                'hm' => $collect['hour_machine'],
                'rapel' => $collect['rapel'],
                'insentif' => $collect['insentif'],
                'tunjangan_lap' => $collect['tunj_lapangan'],
                'bonus' => $collect['bonus'],
                'jht' => $collect['bpjs_tk_jht'],
                'jp' => $collect['bpjs_tk_jp'],
                'bpjs_kesehatan' => $collect['bpjs_kes'],
                'unpaid_leave' => $collect['deduction_unpaid_leave'],
                'deduction' => $collect['deduction'],
                'total_diterima' => $collect['tot_diterima'],
                'account_number' => $collect['bank_number'],
                'bank' => $collect['bank_name'],
                'bank' => $collect['bank_name'],
                'periode' => $collect['periode'],
                'deduction_pph21' => $collect['deduction_pph21'],
                'thr' => $collect['thr'],
                'created_by' => Auth::user()->employee_id
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
