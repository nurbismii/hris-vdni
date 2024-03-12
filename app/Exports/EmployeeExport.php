<?php

namespace App\Exports;

use App\Models\employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return employee::select('*')->take(0)->get();
    }

    public function headings(): array
    {
        return array(
            'Nik', 'No_Sk_Pkwtt', 'Nama_Karyawan', 'Nama_Ibu_Kandung', 'Nama_Bapak', 'Agama', 'No_Ktp', 'No_Kk', 'Kode_Area_Kerja', 'Jenis_Kelamin', 'Status_Perkawinan', 'Status_Karyawan', 'Tgl_Resign', 'Alasan_Resign', 'Status_Resign', 'No_Telp', 'Tgl_Lahir', 'Provinsi_Id', 'Kabupaten_Id', 'Kecamatan_Id', 'Kelurahan_Id', 'Alamat_Ktp', 'Alamat_Domisili', 'Rt', 'Rw', 'Kode_Pos', 'Area_Kerja', 'Golongan_Darah', 'Entry_Date', 'Npwp', 'Status_Pajak', 'Bpjs_Kesehatan', 'Bpjs_Tk', 'Vaksin', 'Jam_Kerja', 'Posisi', 'Jabatan', 'Divisi_Id', 'Tinggi', 'Berat', 'Hobi', 'No_Jamsostek', 'No_Asuransi', 'No_Kartu_Asuransi', 'Nama_Bank', 'No_Rekening', 'Nama_Instansi_Pendidikan', 'Pendidikan_Terakhir', 'Jurusan', 'Tanggal_Kelulusan', 'Tanggal_Menikah', 'Sisa_cuti', 'Sisa_cuti_covid'
        );
    }
}
