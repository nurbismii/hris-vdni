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

        $provinsi_id = $request->provisi_level ?? ['74'];

        $kabupaten_id = $request->kabupaten_level ?? ['7403'];

        $kecamatan_id = $request->kecamatan_level ?? ['7403105'];

        $area_kerja = $request->company_id ?? ['VDNI'];

        $response = employee::select('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->whereIn('provinsi_id', $provinsi_id)
            ->whereIn('kabupaten_id', $kabupaten_id)
            ->whereIn('kecamatan_id', $kecamatan_id)
            ->where('status_resign', 'Aktif')
            ->whereIn('area_kerja', $area_kerja)
            ->selectRaw('COUNT(*) as jumlah_karyawan')
            ->groupBy('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->orderBy('jumlah_karyawan', 'desc')
            ->get();

        return view('wilayah.index', compact('response', 'area_kerja', 'provinsi', 'provinsi_id', 'kabupaten_id', 'kecamatan_id'));
    }

    public function exportExcel($area, $provinsi_id, $kabupaten_id, $kecamatan_id)
    {
        return Excel::download(new WilayahExport($area, $provinsi_id, $kabupaten_id, $kecamatan_id), 'Wilayah-exported.xlsx');
    }

    public function exportPdf($area, $provinsi_id, $kabupaten_id, $kecamatan_id)
    {
        $response = employee::select('area_kerja', 'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->whereIn('provinsi_id', explode(',', $provinsi_id))
            ->whereIn('kabupaten_id', explode(',', $kabupaten_id))
            ->whereIn('kecamatan_id', explode(',', $kecamatan_id))
            ->where('status_resign', 'Aktif')
            ->whereIn('area_kerja', explode(',', $area))
            ->selectRaw('COUNT(*) as jumlah_karyawan')
            ->groupBy('area_kerja', 'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->orderBy('jumlah_karyawan', 'desc')
            ->get();

        $pdf = PDF::loadView('wilayah.wilayah-pdf', compact('response', 'area', 'provinsi_id', 'kabupaten_id', 'kecamatan_id'));
        return $pdf->download('REKAP WILAYAH ' . getNamaProvinsi($provinsi_id) . '-' . getNamaKabupaten($kabupaten_id) . '-' . getNamaKecamatan($kecamatan_id) . '.pdf');
    }
}
