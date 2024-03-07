<?php

namespace App\Imports;

use App\Models\Divisi;
use App\Models\employee;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesUpdateImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $employee;

    public function __construct()
    {
        $this->employee = employee::select('nik', 'no_ktp')->get();
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $collect) {

            $divisi = Divisi::where('nama_divisi', $collect['divisi_id'])->first();

            $data = $this->employee->where('nik', $collect['nik'])->first();

            $data->where('nik', $collect['nik'])->update([
                'no_sk_pkwtt' => $collect['no_sk_pkwtt'],
                'nama_karyawan' => $collect['nama_karyawan'],
                'nama_ibu_kandung' => $collect['nama_ibu_kandung'],
                'nama_bapak' => $collect['nama_bapak'],
                'agama' => $collect['agama'],
                'no_ktp' => str_replace(["'", "`"], "", $collect['no_ktp']),
                'no_kk' => str_replace(["'", "`"], "", $collect['no_kk']),
                'kode_area_kerja' => $collect['kode_area_kerja'],
                'jenis_kelamin' => $collect['jenis_kelamin'] == 'M 男' ? 'L' : 'P',
                'status_perkawinan' => $collect['status_perkawinan'] == 'TK' ? 'Belum Kawin' : 'Kawin',
                'status_karyawan' => $collect['status_karyawan'],
                'tgl_resign' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tgl_resign']))),
                'alasan_resign' => $collect['alasan_resign'],
                'status_resign' => $collect['status_resign'],
                'no_telp' => $collect['no_telp'],
                'tgl_lahir' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tgl_lahir']))),
                'provinsi_id' => $collect['provinsi_id'],
                'kabupaten_id' => $collect['kabupaten_id'],
                'kecamatan_id' => $collect['kecamatan_id'],
                'kelurahan_id' => $collect['kelurahan_id'],
                'alamat_ktp' => $collect['alamat_ktp'],
                'alamat_domisili' => $collect['alamat_domisili'],
                'rt' => $collect['rt'],
                'rw' => $collect['rw'],
                'kode_pos' => $collect['kode_pos'],
                'area_kerja' => $collect['area_kerja'],
                'golongan_darah' => $collect['golongan_darah'],
                'entry_date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['entry_date']))),
                'npwp' => str_replace(array('-', '.'), "", $collect['npwp']),
                'status_pajak' => $collect['status_pajak'],
                'bpjs_kesehatan' => $collect['bpjs_kesehatan'],
                'bpjs_tk' => $collect['bpjs_tk'],
                'vaksin' => $collect['vaksin'],
                'jam_kerja' => $collect['jam_kerja'],
                'posisi' => $collect['posisi'],
                'jabatan' => $collect['jabatan'],
                'divisi_id' => $divisi->id,
                'tinggi' => $collect['tinggi'],
                'berat' => $collect['berat'],
                'hobi' => $collect['hobi'],
                'no_jamsostek' => $collect['no_jamsostek'],
                'no_asuransi' => $collect['no_asuransi'],
                'no_kartu_asuransi' => $collect['no_kartu_asuransi'],
                'nama_bank' => $collect['nama_bank'],
                'no_rekening' => $collect['no_rekening'],
                'nama_instansi_pendidikan' => $collect['nama_instansi_pendidikan'],
                'pendidikan_terakhir' => $collect['pendidikan_terakhir'],
                'jurusan' => $collect['jurusan'],
                'tanggal_kelulusan' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tanggal_kelulusan']))),
                'tanggal_menikah' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intVal($collect['tanggal_menikah']))),
                'sisa_cuti' => $collect['sisa_cuti'],
                'sisa_cuti_covid' => $collect['sisa_cuti_covid'],
            ]);
        }
    }

    public function rules(): array
    {
        return array(
            'nik' => 'required',
        );
    }

    public function customValidationMessages()
    {
        return array(
            'nik.required' => 'NIK Karyawan tidak boleh kosong',
        );
    }
}
