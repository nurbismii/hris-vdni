<?php

namespace App\Http\Controllers;

use App\Imports\ImportKeteranganAbsen;
use App\Models\KeteranganAbsensi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KeteranganAbsensiController extends Controller
{
    public function ImportKeteranganAbsen(Request $request)
    {
        Excel::import(new ImportKeteranganAbsen, $request->file('file'));
        return back()->with('success', 'Data Keterangan Absen Berhasil ditambahkan');
    }

    public function destroy($id)
    {
        KeteranganAbsensi::find($id)->delete();
        return back()->with('success', 'Berhasil menghapus keterangan absensi');
    }
}
