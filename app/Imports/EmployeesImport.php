<?php

namespace App\Imports;

use App\Models\Departemen;
use App\Models\Divisi;
use App\Models\employee;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesImport implements ToCollection, WithHeadingRow, WithChunkReading, WithBatchInserts, WithValidation
{
    protected $allDepartemen;
    protected $allDivisi;
    protected $existingNiks;

    public function __construct()
    {
        $this->allDepartemen = Departemen::pluck('id', 'departemen')->mapWithKey(function ($id, $name) {
            return [strtolower(trim($name)) => $id];
        })->toArray();

        $this->allDivisi = Divisi::pluck('id', 'nama_divisi')->mapWithKeys(function ($id, $name) {
            return [strtolower(trim($name)) => $id];
        })->toArray();

        $this->existingNiks = employee::pluck('nik')->toArray();
    }

    public function collection(Collection $rows)
    {
        $newNiks = [];

        foreach ($rows as $row) {
            $nik = $row['nik'];

            // Skip jika NIK sudah ada di database atau sudah diproses dalam loop ini
            if (in_array($nik, $this->existingNiks) || in_array($nik, $newNiks)) {
                continue;
            }

            // Tambahkan NIK ke daftar yang sudah diproses
            $newNiks[] = $nik;

            $kelurahanId = strval($row['kelurahan_id']);
            $provinsiId = substr($kelurahanId, 0, 2);
            $kabupatenId = substr($kelurahanId, 0, 4);
            $kecamatanId = substr($kelurahanId, 0, 7);

            $departemenId = $this->allDepartemen[strtolower(trim($row['departemen']))] ?? null; 
            $divisiId = $this->allDivisi[strtolower(trim($row['divisi']))] ?? null; 

            employee::create([
                'nik' => $nik,
                'no_sk_pkwtt' => $row['no_sk_pkwtt'],
                'nama_karyawan' => $row['nama_karyawan'],
                'nama_ibu_kandung' => $row['nama_ibu_kandung'],
                'nama_bapak' => $row['nama_bapak'],
                'agama' => $row['agama'],
                'no_ktp' => str_replace(["'", "`"], "", $row['no_ktp']),
                'no_kk' => str_replace(["'", "`"], "", $row['no_kk']),
                'kode_area_kerja' => $row['kode_area_kerja'],
                'jenis_kelamin' => $row['jenis_kelamin'] == 'M 男' ? 'L' : 'P',
                'status_perkawinan' => $row['status_perkawinan'] == 'TK' ? 'Belum Kawin' : 'Kawin',
                'status_karyawan' => $row['status_karyawan'],
                'tgl_resign' => $this->parseDate($row['tgl_resign']),
                'alasan_resign' => $row['alasan_resign'],
                'status_resign' => $row['status_resign'],
                'no_telp' => $row['no_telp'],
                'tgl_lahir' => $this->parseDate($row['tgl_lahir']),
                'provinsi_id' => $provinsiId,
                'kabupaten_id' => $kabupatenId,
                'kecamatan_id' => $kecamatanId,
                'kelurahan_id' => $kelurahanId,
                'alamat_ktp' => $row['alamat_ktp'],
                'alamat_domisili' => $row['alamat_domisili'],
                'rt' => $row['rt'],
                'rw' => $row['rw'],
                'kode_pos' => $row['kode_pos'],
                'area_kerja' => $row['area_kerja'],
                'golongan_darah' => $row['golongan_darah'],
                'entry_date' => $this->parseDate($row['entry_date']),
                'npwp' => str_replace(['-', '.'], '', $row['npwp']),
                'status_pajak' => $row['status_pajak'],
                'bpjs_kesehatan' => $row['bpjs_kesehatan'],
                'bpjs_tk' => $row['bpjs_tk'],
                'vaksin' => $row['vaksin'],
                'jam_kerja' => strtoupper($row['jam_kerja']),
                'posisi' => $row['posisi'],
                'jabatan' => $row['jabatan'],
                'departemen_id' => $departemenId,
                'divisi_id' => $divisiId,
                'tinggi' => $row['tinggi'],
                'berat' => $row['berat'],
                'hobi' => $row['hobi'],
                'no_jamsostek' => $row['no_jamsostek'],
                'no_asuransi' => $row['no_asuransi'],
                'no_kartu_asuransi' => $row['no_kartu_asuransi'],
                'nama_bank' => $row['nama_bank'],
                'no_rekening' => $row['no_rekening'],
                'nama_instansi_pendidikan' => $row['nama_instansi_pendidikan'],
                'pendidikan_terakhir' => $row['pendidikan_terakhir'],
                'jurusan' => $row['jurusan'],
                'tanggal_kelulusan' => $this->parseDate($row['tanggal_kelulusan']),
                'tanggal_menikah' => $this->parseDate($row['tanggal_menikah']),
                'sisa_cuti' => $row['sisa_cuti'],
                'sisa_cuti_covid' => $row['sisa_cuti_covid'],
            ]);
        }
    }

    public function chunkSize(): int
    {
        return 200;
    }

    public function batchSize(): int
    {
        return 100;
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
            'nik.required' => 'NIK karyawan harus diisi',
        ];
    }

    private function parseDate($value)
    {
        try {
            return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject(intval($value)));
        } catch (\Throwable $th) {
            return null;
        }
    }
}
