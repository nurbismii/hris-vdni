<?php

namespace App\Imports;

use App\Models\Divisi;
use App\Models\employee;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class EmployeesUpdateImport implements ToCollection, WithHeadingRow, WithValidation, WithChunkReading
{
    protected $employee;

    public function __construct()
    {
        $this->employee = employee::select('nik', 'no_ktp')->get();
    }

    public function collection(Collection $collection)
    {
        // Ambil dan filter NIK unik dari file
        $nikList = $collection->pluck('nik')->filter()->toArray();

        // Cek duplikat NIK dalam file
        $duplicateInFile = array_diff_assoc($nikList, array_unique($nikList));
        if (!empty($duplicateInFile)) {
            throw new \Exception("Terdapat NIK duplikat dalam file: " . implode(', ', array_unique($duplicateInFile)));
        }

        // Ambil NIK yang sudah ada di database
        $existingEmployees = $this->employee
            ->whereIn('nik', $nikList)
            ->pluck('nik')
            ->all();

        $dataToUpsert = [];

        foreach ($collection as $row) {
            if (empty($row['nik'])) {
                continue; // Lewati baris tanpa NIK
            }

            $divisi = Divisi::where('nama_divisi', $row['divisi'])->first();
            $divisiId = optional($divisi)->id;

            $kelurahanId = strval($row['kelurahan_id']) ?? null;
            $provinsiId = substr($kelurahanId, 0, 2) ?? null;
            $kabupatenId = substr($kelurahanId, 0, 4) ?? null;
            $kecamatanId = substr($kelurahanId, 0, 7) ?? null;

            $toCarbon = fn($val) => is_numeric($val)
                ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((int)$val))
                : null;

            $data = [
                'nik' => $row['nik'],
                'no_sk_pkwtt' => $row['no_sk_pkwtt'],
                'nama_karyawan' => $row['nama_karyawan'],
                'nama_ibu_kandung' => $row['nama_ibu_kandung'],
                'nama_bapak' => $row['nama_bapak'],
                'agama' => $row['agama'],
                'no_ktp' => str_replace(["'", "`"], "", $row['no_ktp']),
                'no_kk' => str_replace(["'", "`"], "", $row['no_kk']),
                'kode_area_kerja' => $row['kode_area_kerja'],
                'jenis_kelamin' => $row['jenis_kelamin'] === 'M 男' ? 'L' : 'P',
                'status_perkawinan' => $row['status_perkawinan'] === 'TK' ? 'Belum Kawin' : 'Kawin',
                'status_karyawan' => $row['status_karyawan'],
                'tgl_resign' => $toCarbon($row['tgl_resign']),
                'alasan_resign' => $row['alasan_resign'],
                'status_resign' => $row['status_resign'],
                'no_telp' => $row['no_telp'],
                'tgl_lahir' => $toCarbon($row['tgl_lahir']),
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
                'entry_date' => $toCarbon($row['entry_date']),
                'npwp' => str_replace(['-', '.'], '', $row['npwp']),
                'status_pajak' => $row['status_pajak'],
                'bpjs_kesehatan' => $row['bpjs_kesehatan'],
                'bpjs_tk' => $row['bpjs_tk'],
                'vaksin' => $row['vaksin'],
                'jam_kerja' => $row['jam_kerja'],
                'posisi' => $row['posisi'],
                'jabatan' => $row['jabatan'],
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
                'tanggal_kelulusan' => $toCarbon($row['tanggal_kelulusan']),
                'tanggal_menikah' => $toCarbon($row['tanggal_menikah']),
                'sisa_cuti' => $row['sisa_cuti'],
                'sisa_cuti_covid' => $row['sisa_cuti_covid'],
            ];

            $dataToUpsert[] = $data;
        }

        // Lakukan upsert jika ada data
        if (!empty($dataToUpsert)) {
            $updateColumns = array_diff(array_keys($dataToUpsert[0]), ['nik']);
            Employee::upsert($dataToUpsert, ['nik'], $updateColumns);
        }
    }

    public function rules(): array
    {
        return ['nik' => 'required'];
    }

    public function customValidationMessages()
    {
        return ['nik.required' => 'NIK Karyawan tidak boleh kosong'];
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
