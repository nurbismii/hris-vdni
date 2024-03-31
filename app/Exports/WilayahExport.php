<?php

namespace App\Exports;

use App\Models\employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WilayahExport implements FromCollection, WithHeadings
{
    protected $area;
    protected $provinsi_id;
    protected $kabupaten_id;
    protected $kecamatan_id;

    function __construct($area, $provinsi_id, $kabupaten_id, $kecamatan_id)
    {
        $this->area = explode(',', $area);
        $this->provinsi_id = explode(',', $provinsi_id);
        $this->kabupaten_id = explode(',', $kabupaten_id);
        $this->kecamatan_id = explode(',', $kecamatan_id);
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $datas = employee::select('area_kerja', 'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->whereIn('provinsi_id', $this->provinsi_id)
            ->whereIn('kabupaten_id', $this->kabupaten_id)
            ->whereIn('kecamatan_id', $this->kecamatan_id)
            ->where('status_resign', 'Aktif')
            ->whereIn('area_kerja', $this->area)
            ->selectRaw('COUNT(*) as jumlah_karyawan')
            ->groupBy('area_kerja', 'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->orderBy('jumlah_karyawan', 'desc')
            ->get();

        foreach ($datas as $row) {
            $wilayah[] = [
                'area' => $row->area_kerja,
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
        return ["AREA", "PROVINSI", "KABUPATEN", "KECAMATAN", "KELURAHAN", "TOTAL KARYAWAN BY KELURAHAN"];
    }
}
