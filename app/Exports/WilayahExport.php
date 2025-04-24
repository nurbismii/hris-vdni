<?php

namespace App\Exports;

use App\Models\employee;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class WilayahExport implements FromArray, WithTitle, WithEvents
{
    protected $mergeInstructions = [];

    public function array(): array
    {
        $data = [];
        $data[] = [
            'NO',
            'PROVINSI',
            'KABUPATEN',
            'KECAMATAN',
            'DESA/KELURAHAN',
            'TOTAL KARYAWAN DESA',
            'TOTAL KARYAWAN KECAMATAN',
            'PRESENTASE DESA',
            'PRESENTASE KECAMATAN/KABUPATEN',
            'PRESENTASE KABUPATEN'
        ];

        $employees = employee::where('status_resign', 'Aktif')->get();
        $kabupatenTotals = $employees->groupBy('kabupaten_id')->map->count();

        $grouped = $employees->groupBy([function ($item) {
            return $item->provinsi_id . '-' . $item->kabupaten_id . '-' . $item->kecamatan_id . '-' . $item->kelurahan_id;
        }]);

        $allRows = [];
        $no = 1;
        $rowIndex = 2;

        $groupedByKab = $grouped->groupBy(function ($rows, $key) {
            $first = $rows->first();
            return $first ? getNamaProvinsi($first->provinsi_id) . '-' . getNamaKabupaten($first->kabupaten_id) : null;
        });

        foreach ($groupedByKab as $kabKey => $kecamatanGroup) {
            if (!$kabKey) continue;
            [$provName, $kabName] = explode('-', $kabKey);
            if (!$provName || !$kabName) continue;

            $kabStart = $rowIndex + 1;

            $groupedKec = $kecamatanGroup->groupBy(function ($rows, $key) {
                $first = $rows->first();
                return $first ? $first->kecamatan_id : null;
            });

            foreach ($groupedKec as $kecId => $desaGroup) {
                if (!$kecId) continue;

                $kecStart = $rowIndex + 1;
                $totalKec = $desaGroup->flatten()->count();
                $totalKab = $kabupatenTotals[$kabName] ?? 0;
                $persenKecKab = $totalKab > 0 ? round(($totalKec / $totalKab) * 100, 2) : 0;
                $persenKab = round(($totalKab / $employees->count()) * 100, 2);

                $desaRows = [];

                foreach (
                    $desaGroup->groupBy(function ($rows, $key) {
                        $first = $rows->first();
                        return $first ? $first->kelurahan_id : null;
                    }) as $desaId => $items
                ) {
                    if (!$desaId) continue;

                    $totalDesa = $items->flatten()->count();
                    $persenDesa = $totalKec > 0 ? round(($totalDesa / $totalKec) * 100, 2) : 0;

                    $desaRows[] = [
                        $no++,
                        $provName,
                        $kabName,
                        'KEC. ' . strtoupper(getNamaKecamatan($kecId)),
                        getNamaKelurahan($desaId),
                        $totalDesa,
                        $totalKec,
                        $persenDesa . '%',
                        $persenKecKab . '%',
                        '',
                    ];
                }

                if (isset($desaRows[0])) {
                    $desaRows[0][9] = $persenKab . '%';
                }

                $kecEnd = $rowIndex + count($desaRows);
                $this->mergeInstructions[] = ["D{$kecStart}:D{$kecEnd}"];

                foreach ($desaRows as $row) {
                    $allRows[] = $row;
                    $rowIndex++;
                }
            }

            $kabEnd = $rowIndex;
            $this->mergeInstructions[] = ["B{$kabStart}:B{$kabEnd}"];
            $this->mergeInstructions[] = ["C{$kabStart}:C{$kabEnd}"];
        }

        $groupedByProv = $employees->groupBy('provinsi_id');
        foreach ($groupedByProv as $provId => $emp) {
            $provName = getNamaProvinsi($provId);
            $start = null;
            $end = null;

            foreach ($allRows as $idx => $row) {
                if ($row[1] === $provName) {
                    if ($start === null) $start = $idx + 2;
                    $end = $idx + 2;
                }
            }

            if ($start !== null && $end !== null && $start !== $end) {
                $this->mergeInstructions[] = ["B{$start}:B{$end}"];
            }
        }

        return array_merge($data, $allRows);
    }

    public function title(): string
    {
        return 'Laporan Wilayah %';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestDataRow();

                $sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'FFFF00'],
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                $sheet->getStyle("A1:J{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                for ($i = 2; $i <= $highestRow; $i++) {
                    $sheet->getStyle("G{$i}")->getFont()->setBold(true);
                    $sheet->getStyle("I{$i}")->getFont()->setBold(true);

                    $value = $sheet->getCell("J{$i}")->getValue();
                    if (!empty($value)) {
                        $sheet->getStyle("J{$i}")->getFont()->getColor()->setRGB(Color::COLOR_RED);
                        $sheet->getStyle("J{$i}")->getFont()->setBold(true);
                    }
                }

                foreach ($this->mergeInstructions as $range) {
                    $sheet->mergeCells($range[0]);
                    $sheet->getStyle($range[0])->getAlignment()->setVertical('center');
                    $sheet->getStyle($range[0])->getAlignment()->setWrapText(true);
                }

                foreach (range('A', 'J') as $col) {
                    $sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
