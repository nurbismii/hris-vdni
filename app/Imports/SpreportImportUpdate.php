<?php

namespace App\Imports;

use App\Models\SpReport;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SpreportImportUpdate implements ToCollection, WithValidation, WithHeadingRow
{
    protected $sp;

    public function __construct()
    {
        $this->sp = SpReport::select('nik_karyawan')->get();
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $collect) {
            $sp_exist = $this->sp->where('nik_karyawan', $collect['nik'])
                ->where('no_sp', $collect['no_sp'])
                ->first();

            if (!$sp_exist) {
                $sp_exist->update([
                    'no_sp' => $collect['no_sp'],
                    'level_sp' => $collect['level_sp'],
                    'tgl_mulai' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tgl_mulai']))),
                    'tgl_berakhir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tgl_berakhir']))),
                    'keterangan' => $collect['keterangan'],
                    'pelapor' => $collect['pelapor'],
                ]);
            }
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
            'nik.required' => 'NIK karyawan wajib diisi',
        ];
    }
}
