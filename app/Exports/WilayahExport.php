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
            ->orderByRaw("
        CASE 
            WHEN provinsi_id = 74 THEN 1
            ELSE 99
        END ASC,
        CASE 
            WHEN area_kerja = 'VDNI' THEN 1
            WHEN area_kerja = 'VDNIP' THEN 2
            ELSE 99
        END ASC,
        CASE 
            WHEN kabupaten_id = 7403 AND kecamatan_id = 7403101 THEN 1
            WHEN kabupaten_id = 7403 AND kecamatan_id = 7403103 THEN 2
            WHEN kabupaten_id = 7403 AND kecamatan_id = 7403105 THEN 3
            WHEN kabupaten_id = 7403 THEN 4
            ELSE 999
        END ASC,
        kecamatan_id ASC
    ")
            ->get()
            ->groupBy(function ($item) {
                // Gabungkan berdasarkan provinsi_id, kabupaten_id, dan kecamatan_id
                return $item->provinsi_id . '-' . $item->kabupaten_id . '-' . $item->kecamatan_id;
            })
            ->map(function ($group) {
                // Gabungkan nilai dari area_kerja, perempuan, laki_laki, dan total
                return [
                    'area_kerja' => $group->pluck('area_kerja')->unique()->implode(', '),
                    'provinsi_id' => $group->first()->provinsi_id,
                    'kabupaten_id' => $group->first()->kabupaten_id,
                    'kecamatan_id' => $group->first()->kecamatan_id,
                    'kelurahan_id' => $group->pluck('kelurahan_id')->unique()->implode(', '),
                    'perempuan' => $group->sum('perempuan'),
                    'laki_laki' => $group->sum('laki_laki'),
                    'total' => $group->sum('total')
                ];
            })
            ->values(); // Reset keys after grouping
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
