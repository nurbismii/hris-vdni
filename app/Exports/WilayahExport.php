<?php

namespace App\Exports;

use App\Models\employee;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class WilayahExport implements FromArray, WithTitle, WithEvents
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function array(): array
    {
        $data = [];

        // Judul dan periode
        $data[] = ['DATA KARYAWAN PER JENIS KELAMIN'];
        $data[] = ["PERIODE {$this->startDate} - {$this->endDate}"];
        $data[] = [''];
        $data[] = [
            'NO',
            'AREA',
            'PROVINSI',
            'KABUPATEN',
            'KECAMATAN',
            'KELURAHAN',
            'PEREMPUAN',
            'LAKI-LAKI',
            'TOTAL'
        ];

        // Query data
        $results = employee::selectRaw('
                area_kerja,
                provinsi_id,
                kabupaten_id,
                kecamatan_id,
                kelurahan_id,
                SUM(CASE WHEN jenis_kelamin = "P" THEN 1 ELSE 0 END) as perempuan,
                SUM(CASE WHEN jenis_kelamin = "L" THEN 1 ELSE 0 END) as laki_laki,
                COUNT(*) as total
            ')
            ->where('status_resign', 'Aktif')
            ->groupBy('area_kerja', 'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->orderByDesc('total')
            ->get();

        $no = 1;
        foreach ($results as $row) {
            $data[] = [
                $no++,
                $row->area_kerja,
                getNamaProvinsi($row->provinsi_id),
                getNamaKabupaten($row->kabupaten_id),
                getNamaKecamatan($row->kecamatan_id),
                getNamaKelurahan($row->kelurahan_id),
                $row->perempuan,
                $row->laki_laki,
                $row->total,
            ];
        }

        return $data;
    }

    public function title(): string
    {
        return 'Laporan Per Wilayah & Gender';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:A2')->getFont()->setBold(true);
                $event->sheet->getStyle('A4:I4')->getFont()->setBold(true);
            },
        ];
    }
}
