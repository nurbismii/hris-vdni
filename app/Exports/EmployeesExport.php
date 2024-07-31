<?php

namespace App\Exports;

use App\Models\employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return employee::with('divisi', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan')->where('status_resign', '!=', null)->get();
    }

    public function headings(): array
    {
        return [
            'NIK Karyawan',
            'NO SK PKWTT',
            'NAMA',
            'NAMA IBU KANDUNG',
            'NAMA BAPAK',
            'AGAMA',
            'NO KTP',
            'NO KK',
            'KODE AREA KERJA',
            'JENIS KELAMIN',
            'STATUS PERKAWINAN',
            'STATUS KARYAWAN',
            'TANGGAL RESIGN',
            'STATUS RESIGN',
            'TELP',
            'TANGGAL LAHIR',
            'PROVINSI',
            'KABUPATEN',
            'KECAMATAN',
            'KELURAHAN',
            'ALAMAT KTP',
            'ALAMAT DOMISILI',
            'RT',
            'RW',
            'KODE POS',
            'AREA KERJA',
            'GOL DARAH',
            'ENTRY DATE',
            'NPWP',
            'STATUS PAJAK',
            'BPJS KESEHATAN',
            'BPJS TK',
            'VAKSIN',
            'JAM KERJA',
            'POSISI',
            'JABATAN',
            'DIVISI',
            'TINGGI',
            'BERAT',
            'HOBI',
            'NO JAMSOSTEK',
            'NO ASURANSI',
            'NO KARTU ASURANSI',
            'BANK',
            'NO REKENING',
            'INSTANSI PENDIDIKAN',
            'PENDIDIKAN TERAKHIR',
            'JURUSAN',
            'TANGGAL KELULUSAN',
            'TANGGAL MENIKAH',
        ];
    }

    public function map($employee): array
    {
        return [
            $employee['nik'],
            $employee['no_sk_pkwtt'],
            $employee['nama_karyawan'],
            $employee['nama_ibu_kandung'],
            $employee['nama_bapak'],
            $employee['agama'],
            "'" . $employee['no_ktp'], // Prepend a single quote to force text format
            "'" . $employee['no_kk'],  // Prepend a single quote to force text format
            $employee['kode_area_kerja'],
            $employee['jenis_kelamin'] == 'M 男' ? 'L' : 'P',
            $employee['status_perkawinan'] == 'TK' ? 'Belum Kawin' : 'Kawin',
            $employee['status_karyawan'],
            $employee['tgl_resign'] == '1970-01-01' ? '-' : $employee['tgl_resign'],
            $employee['status_resign'],
            $employee['no_telp'],
            $employee['tgl_lahir'] == '1970-01-01' ? '-' : $employee['tgl_lahir'],
            $employee->provinsi->provinsi ?? '-',
            $employee->kabupaten->kabupaten ?? '-',
            $employee->kecamatan->kecamatan ?? '-',
            $employee->kelurahan->kelurahan ?? '-',
            $employee['alamat_ktp'],
            $employee['alamat_domisili'],
            $employee['rt'],
            $employee['rw'],
            $employee['kode_pos'],
            $employee['area_kerja'],
            $employee['golongan_darah'],
            $employee['entry_date'] == '1970-01-01' ? '-' : $employee['entry_date'],
            "'" . $employee['npwp'], // Prepend a single quote to force text format
            $employee['status_pajak'],
            $employee['bpjs_kesehatan'],
            $employee['bpjs_tk'],
            $employee['vaksin'],
            strtoupper($employee['jam_kerja']),
            $employee['posisi'],
            $employee['jabatan'],
            $employee->divisi->nama_divisi ?? '-',
            $employee['tinggi'],
            $employee['berat'],
            $employee['hobi'],
            $employee['no_jamsostek'],
            $employee['no_asuransi'],
            $employee['no_kartu_asuransi'],
            $employee['nama_bank'],
            "'" . $employee['no_rekening'], // Prepend a single quote to force text format
            $employee['nama_instansi_pendidikan'],
            $employee['pendidikan_terakhir'],
            $employee['jurusan'],
            $employee['tanggal_kelulusan'] == '1970-01-01' ? '-' : $employee['tanggal_kelulusan'],
            $employee['tanggal_menikah'] == '1970-01-01' ? '-' : $employee['tanggal_menikah'],
        ];
    }
}
