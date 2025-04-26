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
        $provinsi = Provinsi::all();

        $provinsi_id = $request->provisi_level ?? ['74'];
        $kabupaten_id = $request->kabupaten_level ?? ['7403'];
        $kecamatan_id = $request->kecamatan_level ?? ['7403105'];
        $area_kerja = $request->company_id ?? ['VDNI'];

        $arr_jumlah_karyawan = [];
        $arr_nama_kelurahan = [];

        // Query data lengkap termasuk jenis_kelamin
        $response = employee::select('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id', 'jenis_kelamin')
            ->whereIn('provinsi_id', $provinsi_id)
            ->whereIn('kabupaten_id', $kabupaten_id)
            ->whereIn('kecamatan_id', $kecamatan_id)
            ->where('status_resign', 'Aktif')
            ->whereIn('area_kerja', $area_kerja)
            ->selectRaw('COUNT(*) as jumlah_karyawan')
            ->groupBy('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id', 'jenis_kelamin')
            ->orderBy('jumlah_karyawan', 'desc')
            ->get();

        // Struktur data terformat
        $groupedData = [];

        foreach ($response as $data) {
            $kabupaten = $data->kabupaten_id;
            $kecamatan = $data->kecamatan_id;
            $kelurahan = $data->kelurahan_id;

            // Normalisasi jenis kelamin
            $jk = strtolower($data->jenis_kelamin);
            if ($jk === 'l' || $jk === 'laki-laki') {
                $gender = 'laki-laki';
            } elseif ($jk === 'p' || $jk === 'perempuan') {
                $gender = 'perempuan';
            } else {
                continue;
            }

            // Inisialisasi array jika belum ada
            if (!isset($groupedData[$kabupaten][$kecamatan][$kelurahan])) {
                $groupedData[$kabupaten][$kecamatan][$kelurahan] = [
                    'laki-laki' => 0,
                    'perempuan' => 0,
                    'jumlah' => 0,
                    'kelurahan_id' => $kelurahan,
                ];
            }

            $groupedData[$kabupaten][$kecamatan][$kelurahan][$gender] += $data->jumlah_karyawan;
            $groupedData[$kabupaten][$kecamatan][$kelurahan]['jumlah'] += $data->jumlah_karyawan;
        }

        // Ambil nama kelurahan dan jumlah total untuk chart
        foreach ($groupedData as $kecamatan) {
            foreach ($kecamatan as $kelurahans) {
                foreach ($kelurahans as $data) {
                    $arr_jumlah_karyawan[] = $data['jumlah'];
                    $arr_nama_kelurahan[] = getNamaKelurahan($data['kelurahan_id']);
                }
            }
        }

        return view('wilayah.index', [
            'arr_jumlah_karyawan' => $arr_jumlah_karyawan,
            'arr_nama_kelurahan' => $arr_nama_kelurahan,
            'array' => json_decode(json_encode($groupedData), true), // jika perlu sebagai array murni
            'response' => $groupedData,
            'area_kerja' => $area_kerja,
            'provinsi' => $provinsi,
            'provinsi_id' => $provinsi_id,
            'kabupaten_id' => $kabupaten_id,
            'kecamatan_id' => $kecamatan_id,
        ]);
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

        $response = employee::select(
            'provinsi_id',
            'kabupaten_id',
            'kecamatan_id',
            'kelurahan_id',
            'jenis_kelamin'
        )
            ->whereIn('provinsi_id', $prov_arr)
            ->whereIn('kabupaten_id', $kab_arr)
            ->whereIn('kecamatan_id', $kec_arr)
            ->where('status_resign', 'Aktif')
            ->whereIn('area_kerja', $area_arr)
            ->selectRaw('COUNT(*) as jumlah_karyawan')
            ->groupBy(
                'provinsi_id',
                'kabupaten_id',
                'kecamatan_id',
                'kelurahan_id',
                'jenis_kelamin'
            )
            ->orderBy('jumlah_karyawan', 'desc')
            ->get()
            ->groupBy(['kabupaten_id', 'kecamatan_id', 'jenis_kelamin']);

        $array = json_decode($response, true);

        $pdf = PDF::loadView('wilayah.wilayah-pdf', compact(
            'array',
            'response',
            'area_arr',
            'prov_arr',
            'kab_arr',
            'kec_arr',
            'area',
            'provinsi_id',
            'kabupaten_id',
            'kecamatan_id'
        ));

        return $pdf->stream();
    }
}
