<?php

namespace App\Http\Controllers;

use App\Exports\WilayahExport;
use App\Models\employee;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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

    public function exportPdf($area, $provinsi_id, $kabupaten_id, $kecamatan_id)
    {
        $response = employee::select('area_kerja', 'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->where('provinsi_id', $provinsi_id)
            ->where('kabupaten_id', $kabupaten_id)
            ->where('kecamatan_id', $kecamatan_id)
            ->where('status_resign', 'Aktif')
            ->where('area_kerja', $area)
            ->selectRaw('COUNT(*) as jumlah_karyawan')
            ->groupBy('area_kerja', 'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->orderBy('jumlah_karyawan', 'desc')
            ->get();

        $pdf = PDF::loadView('wilayah.wilayah-pdf', compact('response', 'area', 'provinsi_id', 'kabupaten_id', 'kecamatan_id'));
        return $pdf->download('REKAP WILAYAH ' . getNamaProvinsi($provinsi_id) . '-' . getNamaKabupaten($kabupaten_id) . '-' . getNamaKecamatan($kecamatan_id) . '.pdf');
    }
}
