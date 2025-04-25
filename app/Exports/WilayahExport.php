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
        $data = [[
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
        ]];

        $employees = employee::where('status_resign', 'Aktif')->get();
        $kabupatenTotals = $employees->groupBy('kabupaten_id')->map->count();
        $totalAll = $employees->count();

        $grouped = $employees->groupBy([
            fn($item) => $item->provinsi_id . '-' . $item->kabupaten_id,
            fn($item) => $item->kecamatan_id,
            fn($item) => $item->kelurahan_id,
        ]);

        $allRows = [];
        $no = 1;
        $rowIndex = 2;

        $provGroupMap = [];

        foreach ($grouped as $provKabKey => $kecGroups) {
            [$provId, $kabId] = explode('-', $provKabKey);
            $provName = getNamaProvinsi($provId);
            $kabName = getNamaKabupaten($kabId);
            $totalKab = $kabupatenTotals[$kabId] ?? 0;
            $persenKab = $totalAll > 0 ? round(($totalKab / $totalAll) * 100, 2) : 0;

            $kabStart = $rowIndex + 1;
            $totalKabCount = 0;

            foreach ($kecGroups as $kecId => $desaGroups) {
                $kecStart = $rowIndex + 1;
                $totalKec = collect($desaGroups)->flatten()->count();
                $persenKecKab = $totalKab > 0 ? round(($totalKec / $totalKab) * 100, 2) : 0;

                $desaRows = [];

                foreach ($desaGroups as $desaId => $items) {
                    $totalDesa = $items->count();
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

                    $totalKabCount += $totalDesa;
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

            // Subtotal Kabupaten
            $allRows[] = [
                '',
                '',
                '',
                "Subtotal Kabupaten {$kabName}",
                '',
                $totalKabCount,
                '',
                '',
                '',
                $persenKab . '%'
            ];
            $rowIndex++;

            $kabEnd = $rowIndex - 1;
            $this->mergeInstructions[] = ["B{$kabStart}:B{$kabEnd}"];
            $this->mergeInstructions[] = ["C{$kabStart}:C{$kabEnd}"];

            // Catat provinsi untuk subtotal nanti
            $provGroupMap[$provName][] = [
                'count' => $totalKabCount,
                'lastRow' => $rowIndex
            ];
        }

        // Subtotal Provinsi
        foreach ($provGroupMap as $provName => $infos) {
            $totalProv = array_sum(array_column($infos, 'count'));
            $lastRow = end($infos)['lastRow'];

            $allRows[] = [
                '',
                '',
                '',
                "Subtotal Provinsi {$provName}",
                '',
                $totalProv,
                '',
                '',
                '',
                round(($totalProv / $totalAll) * 100, 2) . '%'
            ];
            $rowIndex++;
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

                for ($i = 2; $i <= $highestRow; $i++) {
                    $colD = $sheet->getCell("D{$i}")->getValue();

                    // Warna subtotal kabupaten
                    if (is_string($colD) && str_starts_with($colD, 'Subtotal Kabupaten')) {
                        $sheet->getStyle("A{$i}:J{$i}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'D9D9D9'], // abu-abu muda
                            ],
                            'font' => ['bold' => true],
                        ]);
                    }

                    // Warna subtotal provinsi
                    if (is_string($colD) && str_starts_with($colD, 'Subtotal Provinsi')) {
                        $sheet->getStyle("A{$i}:J{$i}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'B7E1CD'], // hijau muda
                            ],
                            'font' => ['bold' => true],
                        ]);
                    }
                }
            },
        ];
    }
}
