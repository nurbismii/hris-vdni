<?php

namespace App\Http\Controllers;

use App\Exports\WilayahExport;
use App\Models\employee;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class WilayahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $provinsi = Provinsi::all();

        $provinsi_id = $request->provinsi_id ?? '74';

        $kabupaten_id = $request->kabupaten ?? '7403';

        $kecamatan_id = $request->kecamatan ?? '7403105';

        $area_kerja = $request->area_kerja ?? 'VDNI';

        $response = employee::select('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->where('provinsi_id', $provinsi_id)
            ->where('kabupaten_id', $kabupaten_id)
            ->where('kecamatan_id', $kecamatan_id)
            ->where('status_resign', 'Aktif')
            ->where('area_kerja', $area_kerja)
            ->selectRaw('COUNT(*) as jumlah_karyawan')
            ->groupBy('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->orderBy('jumlah_karyawan', 'desc')
            ->get();

        return view('wilayah.index', compact('response', 'area_kerja', 'provinsi', 'provinsi_id', 'kabupaten_id', 'kecamatan_id'));
    }

    public function exportExcel($area, $provinsi_id, $kabupaten_id, $kelurahan_id)
    {
        return Excel::download(new WilayahExport($area, $provinsi_id, $kabupaten_id, $kelurahan_id), 'Wilayah-exported.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
