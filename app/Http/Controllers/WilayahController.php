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
            ->get()
            ->groupBy(['kabupaten_id', 'kecamatan_id']);

        $array = json_decode($response, true);

        return view('wilayah.index', compact('array', 'response', 'area_kerja', 'provinsi', 'provinsi_id', 'kabupaten_id', 'kecamatan_id'));
    }

    public function exportExcel($area, $provinsi_id, $kabupaten_id, $kecamatan_id)
    {
        return Excel::download(new WilayahExport($area, $provinsi_id, $kabupaten_id, $kecamatan_id), 'Wilayah-exported.xlsx');
    }

    public function exportPdf($area, $provinsi_id, $kabupaten_id, $kecamatan_id)
    {
        $area_arr = explode(',', $area);
        $prov_arr = explode(',', $provinsi_id);
        $kab_arr = explode(',', $kabupaten_id);
        $kec_arr = explode(',', $kecamatan_id);

        $response = employee::select('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->whereIn('provinsi_id', explode(',', $provinsi_id))
            ->whereIn('kabupaten_id', explode(',', $kabupaten_id))
            ->whereIn('kecamatan_id', explode(',', $kecamatan_id))
            ->where('status_resign', 'Aktif')
            ->whereIn('area_kerja', explode(',', $area))
            ->selectRaw('COUNT(*) as jumlah_karyawan')
            ->groupBy('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
            ->orderBy('jumlah_karyawan', 'desc')
            ->get()
            ->groupBy(['kabupaten_id', 'kecamatan_id']);

        $array = json_decode($response, true);

        $pdf = PDF::loadView('wilayah.wilayah-pdf', compact('array', 'response', 'area_arr', 'prov_arr', 'kab_arr', 'kec_arr', 'area', 'provinsi_id', 'kabupaten_id', 'kecamatan_id'));
        return $pdf->stream();
    }
}
