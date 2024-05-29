<?php

namespace App\Http\Controllers;

use App\Imports\ImportDestroyDetailAbsensi;
use App\Imports\ImportDetailAbsensi;
use App\Models\DetailAbsensi;
use App\Models\Divisi;
use App\Models\employee;
use App\Models\KeteranganAbsensi;
use App\Models\PeriodeBulan;
use App\Models\PeriodeTahun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Expr\FuncCall;
use Yajra\DataTables\DataTables;

class DetailAbsensiController extends Controller
{

    public function getDetailAbsensi(Request $request)
    {
        $data_absen = [];
        $periode = [];
        if ($request->awal_periode && $request->akhir_periode) {
            $periode = DetailAbsensi::where('awal_periode', $request->awal_periode)->where('akhir_periode', $request->akhir_periode)->first();
            $data_absen = DetailAbsensi::where('awal_periode', $request->awal_periode)->where('akhir_periode', $request->akhir_periode)->get();
        }
        return view('kehadiran.detail', compact('data_absen', 'periode'));
    }

    public function getDetailAllIn()
    {
        return view('kehadiran.all-in');
    }

    public function importAbsensi(Request $request)
    {
        Excel::import(new ImportDetailAbsensi, $request->file('file'));
        return back()->with('success', 'Data absensi berhasil ditambahkan');
    }

    public function importDeleteAbsensi(Request $request)
    {
        Excel::import(new ImportDestroyDetailAbsensi, $request->file('file'));
        return back()->with('success', 'Data absensi berhasil dihapus');
    }

    public function serverSideAllin()
    {
        $data = employee::where('kode_area_kerja', '!=', null)->select('*');
        return DataTables::of($data)->addColumn('action', function ($data) {
            return view('kehadiran._action', [
                'data' => $data,
                'url_show' => route('all-in/detail', $data->nik),
            ]);
        })->addIndexColumn()->rawColumns(['action'])->make(true);
    }

    public function show($nik)
    {
        $data = employee::with(['detailAbsen', 'keteranganAbsen'])->where('nik', $nik)->first();
        $keterangan_absen = $data->keteranganAbsen;
        return view('kehadiran.all-in-detail', compact('data', 'keterangan_absen'))->with('no');
    }
}
