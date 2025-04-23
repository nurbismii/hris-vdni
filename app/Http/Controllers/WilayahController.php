<?php

namespace App\Http\Controllers;

use App\Exports\WilayahExport;
use App\Models\employee;
use App\Models\Provinsi;
use Carbon\Carbon;
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

        $arr_jumlah_karyawan = [];
        $arr_nama_kelurahan = [];

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

        foreach ($response as $kecamatan) {
            foreach ($kecamatan as $karyawan) {
                foreach ($karyawan as $data) {
                    $arr_jumlah_karyawan[] = $data->jumlah_karyawan;
                    $arr_nama_kelurahan[] = getNamaKelurahan($data->kelurahan_id);
                }
            }
        }

        return view('wilayah.index', compact('arr_jumlah_karyawan', 'arr_nama_kelurahan', 'array', 'response', 'area_kerja', 'provinsi', 'provinsi_id', 'kabupaten_id', 'kecamatan_id'));
    }

    public function exportExcel($area, $provinsi_id, $kabupaten_id, $kecamatan_id)
    {
        $bulan_sekarang = date('Y-m', strtotime(Carbon::now()));

        $tanggal_hari_ini = $bulan_sekarang . '-16';
        $tanggal_hari_ini = date('Y-m-d', strtotime("$tanggal_hari_ini -1 Month"));
        $bulan_depan = date('Y-m-d', strtotime("$tanggal_hari_ini +1 Month -1 Day"));

        $start_date = $tanggal_hari_ini;
        $end_date = $bulan_depan;

        return Excel::download(new WilayahExport($start_date, $end_date), 'Laporan Karyawan Perwilayah.xlsx');
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
