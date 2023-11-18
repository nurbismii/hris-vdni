<?php

namespace App\Imports;

use App\Models\Severancepay;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PesangonImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $collect) {
            $datas[] = [
                'nik_karyawan' => $collect['nik_karyawan'],
                'pasal' => strtolower($collect['pasal']),
                'pelanggaran' => $collect['pelanggaran'],
                'bil_severance' => $collect['bil_konstan_pesangon'],
                'remaining_leave' => $collect['sisa_cuti'],
                'net_salary' => $collect['gaji_bersih'],
                'subtotal_severance' => $collect['subtotal_pesangon'],
                'basic_salary' => $collect['bil_konstan_penghargaan'],
                'service_year' => $collect['masa_kerja'],
                'subtotal_award' => $collect['subtotal_penghargaan'],
                'bil_annual' => $collect['bil_konstan_cuti'],
                'subtotal_annual' => $collect['subtotal_cuti'],
                'bil_compensation' => $collect['bil_konstan_kompensasi'],
                'return_cost' => $collect['ongkos_pulang'],
                'total_severance' => number_format($collect['total_pesangon']),
                'payroll_period' => date('Y-m', strtotime(Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['periode_payroll']))))),
                'termination_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tanggal_phk']))),
                'created_at' =>  Carbon::now()->format('Y-m-d H:i:s')
            ];
        }

        foreach (array_chunk($datas, 300) as $chunk) {
            Severancepay::insert($chunk);
        }
    }

    public function rules(): array
    {
        return [

        ];
    }

    public function customValidationMessages()
    {
        return [

        ];
    }
}
