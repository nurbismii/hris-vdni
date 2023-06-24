<?php

namespace App\Imports;

use App\Models\KaryawanRoster;
use App\Models\Pengingat;
use App\Models\PeriodeRoster;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class KaryawanRosterImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $collection)
    {
        $datas = [];
        foreach ($collection as $collect) {
            $check = KaryawanRoster::where('periode_id', $collect['periode_id'])->first();
            $datas[] = array(
                'nik_karyawan' => $collect['nik_karyawan'],
                'periode_id' => $collect['periode_id'],
                'minggu_pertama' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['i']))) ?? null,
                'minggu_kedua' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['ii']))) ?? null,
                'minggu_ketiga' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['iii']))) ?? null,
                'minggu_keempat' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['iv']))) ?? null,
                'minggu_kelima' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['v']))) ?? null,
            );
        }
        if($check){
            return redirect('roster')->with('warning', 'Data yang diimport telah tersedia!');
        }
        foreach (array_chunk($datas, 100) as $chunk) {
            KaryawanRoster::insert($chunk);
        }

        $minggu_pertama = [];
        $minggu_kedua = [];
        $minggu_ketiga = [];
        $minggu_keempat = [];
        $minggu_kelima = [];

        $data_pengingat = Pengingat::where('periode_id', $collect['periode_id'])->first();

        if ($data_pengingat) {
            return back()->with('error', 'Periode sudah terdaftar dalam pengingat');
        }

        $data_periode = PeriodeRoster::where('id', $collect['periode_id'])->first();

        $data_minggu_pertama = KaryawanRoster::where('periode_id', $collect['periode_id'])->get(['id', 'nik_karyawan', 'periode_id', 'minggu_pertama']);
        $data_minggu_kedua = KaryawanRoster::where('periode_id', $collect['periode_id'])->get(['id', 'nik_karyawan', 'periode_id', 'minggu_kedua']);
        $data_minggu_ketiga = KaryawanRoster::where('periode_id', $collect['periode_id'])->get(['id', 'nik_karyawan', 'periode_id', 'minggu_ketiga']);
        $data_minggu_keempat = KaryawanRoster::where('periode_id', $collect['periode_id'])->get(['id', 'nik_karyawan', 'periode_id', 'minggu_keempat']);
        $data_minggu_kelima = KaryawanRoster::where('periode_id', $collect['periode_id'])->get(['id', 'nik_karyawan', 'periode_id', 'minggu_kelima']);

        foreach ($data_minggu_pertama as $row) {
            $minggu_pertama[] =  [
                'roster_id' => $row->id,
                'nik_karyawan' => $row->nik_karyawan,
                'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti pertama periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode . ' pada tanggal ' . $row->minggu_pertama,
                'periode_id' => $row->periode_id,
                'periode_mingguan' => '1',
                'tanggal_cuti' => $row->minggu_pertama,
                'flg_kirim' => 0
            ];
        }

        foreach ($data_minggu_kedua as $row) {
            $minggu_kedua[] =  [
                'roster_id' => $row->id,
                'nik_karyawan' => $row->nik_karyawan,
                'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti kedua periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode . ' pada tanggal ' . $row->minggu_kedua,
                'periode_id' => $row->periode_id,
                'periode_mingguan' => '2',
                'tanggal_cuti' => $row->minggu_kedua,
                'flg_kirim' => 0
            ];
        }

        foreach ($data_minggu_ketiga as $row) {
            $minggu_ketiga[] =  [
                'roster_id' => $row->id,
                'nik_karyawan' => $row->nik_karyawan,
                'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti ketiga periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode . ' pada tanggal ' . $row->minggu_ketiga,
                'periode_id' => $row->periode_id,
                'periode_mingguan' => '3',
                'tanggal_cuti' => $row->minggu_ketiga,
                'flg_kirim' => 0
            ];
        }
        foreach ($data_minggu_keempat as $row) {
            $minggu_keempat[] =  [
                'roster_id' => $row->id,
                'nik_karyawan' => $row->nik_karyawan,
                'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti keempat periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode . ' pada tanggal ' . $row->minggu_keempat,
                'periode_id' => $row->periode_id,
                'periode_mingguan' => '4',
                'tanggal_cuti' => $row->minggu_keempat,
                'flg_kirim' => 0
            ];
        }

        foreach ($data_minggu_kelima as $row) {
            $minggu_kelima[] =  [
                'roster_id' => $row->id,
                'nik_karyawan' => $row->nik_karyawan,
                'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti kelima periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode . ' pada tanggal ' . $row->minggu_kelima,
                'periode_id' => $row->periode_id,
                'periode_mingguan' => '5',
                'tanggal_cuti' => $row->minggu_kelima,
                'flg_kirim' => 0
            ];
        }

        if (count($minggu_pertama) > 0) {
            $batch_pengingat = array_merge($minggu_pertama, $minggu_kedua, $minggu_ketiga, $minggu_keempat, $minggu_kelima);
            foreach (array_chunk($batch_pengingat, 300) as $chunk) {
                Pengingat::insert($chunk);
            }
            return redirect('roster')->with('success', 'Data Karyawan Roster Berhasil ditambahkan');
        }
    }

    public function rules(): array
    {
        return [
            'nik_karyawan' => 'required',
            'periode_id' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nik_karyawan.required' => 'NIK karyawan harus diisi',
            'periode_id.required' => 'ID Periode Tahun harus diisi',

        ];
    }
}
