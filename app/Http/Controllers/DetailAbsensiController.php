<?php

namespace App\Http\Controllers;

use App\Imports\ImportDetailAbsensi;
use App\Models\DetailAbsensi;
use App\Models\PeriodeBulan;
use App\Models\PeriodeTahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class DetailAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tahun = [];
        $bulan = [];
        $datas = PeriodeTahun::with('periode_bulan')->get();
        foreach ($datas as $data) {
            $tahun = [
                'id' => $data->id,
                'tahun' => $data->tahun
            ];
            $bulan = $data->periode_bulan;
        }
        return view('customize_setting.periode_absen.index', compact('tahun', 'bulan', 'datas'))->with('no');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $tahun = PeriodeTahun::create([
                'tahun' => $request->tahun,
            ]);

            $bulan = $request['bulan'];

            for ($i = 0; $i < count($bulan); $i++) {
                $datas[] = [
                    'periode_tahun_id' => $tahun->id,
                    'nama_bulan' => $bulan[$i],
                ];
            }
            PeriodeBulan::insert($datas);
            DB::commit();
            return back()->with('success', 'Periode tahun dan bulan berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan!');
        }
    }

    public function getDetailAbsensi(Request $request)
    {
        $datas = PeriodeTahun::all();
        $data_absen = [];
        if ($request->tahun_id && $request->bulan_id) {
            $tahun = PeriodeTahun::where('id', $request->tahun_id)->first();
            $bulan = PeriodeBulan::where('id', $request->bulan_id)->where('periode_tahun_id', $tahun->id)->first();
            $data_absen = DetailAbsensi::where('periode_bulan_id', $bulan->id)->get();
        }
        return view('kehadiran.detail', compact('datas', 'data_absen'));
    }


    public function dropwdownBulan($id)
    {
        $bulan = PeriodeBulan::where('periode_tahun_id', $id)->get();
        return response()->json($bulan);
    }

    public function serverSideDetailAbsensi()
    {
        $data = DetailAbsensi::query();
        return DataTables::of($data)->addColumn('action', function ($data) {
            return view('kehadiran._action', [
                'data' => $data,
                'url_show' => route('detailAbsen.show', $data->nik_karyawan),
            ]);
        })->addIndexColumn()->rawColumns(['action'])->make(true);
    }

    public function importAbsensi(Request $request)
    {
        Excel::import(new ImportDetailAbsensi, $request->file('file'));
        return back()->with('success', 'Data Karyawan Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DetailAbsensi  $detailAbsensi
     * @return \Illuminate\Http\Response
     */
    public function show(DetailAbsensi $detailAbsensi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DetailAbsensi  $detailAbsensi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DetailAbsensi $detailAbsensi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailAbsensi  $detailAbsensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailAbsensi $detailAbsensi)
    {
        //
    }
}
