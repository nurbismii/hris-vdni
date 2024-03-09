<?php

namespace App\Exports;

use App\Models\employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WilayahExport implements FromCollection, WithHeadings
{
    protected $provinsi_id;
    protected $kabupaten_id;
    protected $kecamatan_id;

    function __construct($provinsi_id, $kabupaten_id, $kecamatan_id)
    {
        $this->provinsi_id = $provinsi_id;
        $this->kabupaten_id = $kabupaten_id;
        $this->kecamatan_id = $kecamatan_id;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $datas = employee::select('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->where('provinsi_id', $this->provinsi_id)
            ->where('kabupaten_id', $this->kabupaten_id)
            ->where('kecamatan_id', $this->kecamatan_id)
            ->where('status_resign', 'Aktif')
            ->selectRaw('COUNT(*) as jumlah_karyawan')
            ->groupBy('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->orderBy('jumlah_karyawan', 'desc')
            ->get();

        foreach ($datas as $row) {
            $wilayah[] = [
                'provinsi' => getNamaProvinsi($row->provinsi_id),
                'kabupaten' => getNamaKabupaten($row->kabupaten_id),
                'kecamatan' => getNamaKecamatan($row->kecamatan_id),
                'kelurahan' => getNamaKelurahan($row->kelurahan_id),
                'total_karyawan_kelurahan' => $row->jumlah_karyawan,
            ];
        }

        return collect($wilayah);
    }

    public function headings(): array
    {
        return ["PROVINSI", "KABUPATEN", "KECAMATAN", "KELURAHAN", "TOTAL KARYAWAN BY KELURAHAN"];
    }
}