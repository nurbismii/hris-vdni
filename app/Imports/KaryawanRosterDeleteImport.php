<?php

namespace App\Imports;

use App\Models\KaryawanRoster;
use App\Models\Pengingat;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KaryawanRosterDeleteImport implements ToModel, WithHeadingRow
{
    protected $rosters;
    protected $pengingats;

    public function __construct()
    {
        $this->rosters = KaryawanRoster::select('nik_karyawan', 'periode_id')->get();
        $this->pengingats = Pengingat::select('nik_karyawan', 'periode_id')->get();
    }

    public function model(array $row)
    {
        KaryawanRoster::where('nik_karyawan', $row['nik_karyawan'])->where('periode_id', $row['periode_id'])->chunkById(300, function ($rosters) {
            foreach ($rosters as $roster) {
                $roster->delete();
            }
        });
        Pengingat::where('nik_karyawan', $row['nik_karyawan'])->where('periode_id', $row['periode_id'])->chunkById(300, function ($pengingats) {
            foreach ($pengingats as $pengingat) {
                $pengingat->delete();
            }
        });
    }
}
