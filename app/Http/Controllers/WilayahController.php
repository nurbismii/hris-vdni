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

        // Default filter
        $provinsi_id = $request->provisi_level ?? ['74'];
        $kabupaten_id = $request->kabupaten_level ?? ['7403'];
        $kecamatan_id = $request->kecamatan_level ?? ['7403105'];
        $area_kerja = $request->company_id ?? ['VDNI'];

        $arr_jumlah_karyawan = [];
        $arr_nama_kelurahan = [];

        // Ambil data karyawan per wilayah dan jenis kelamin
        $response = employee::select('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id', 'jenis_kelamin')
            ->where('status_resign', 'Aktif')
            ->whereIn('area_kerja', $area_kerja)
            ->selectRaw('COUNT(*) as jumlah_karyawan')
            ->groupBy('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id', 'jenis_kelamin')
            ->orderBy('jumlah_karyawan', 'desc')
            ->get();

        // Struktur data terformat
        $groupedData = [
            'Sulawesi' => [],
            'Sulawesi Tenggara' => [],
            'Non Sulawesi' => [],
        ];

        $sulawesi_ids = ['71', '62', '73', '75', '76'];
        $sultra_ids = ['74'];

        foreach ($response as $data) {
            $prov_id = $data->provinsi_id;
            $kab_id = $data->kabupaten_id;
            $kec_id = $data->kecamatan_id;
            $kel_id = $data->kelurahan_id;

            $jk = strtolower($data->jenis_kelamin);
            $gender = $jk === 'l' || $jk === 'laki-laki' ? 'laki-laki' : ($jk === 'p' || $jk === 'perempuan' ? 'perempuan' : null);
            if (!$gender) continue;

            // Tentukan grup wilayah
            if (in_array($prov_id, $sultra_ids)) {
                $region = 'Sulawesi Tenggara';
            } elseif (in_array($prov_id, $sulawesi_ids)) {
                $region = 'Sulawesi';
            } else {
                $region = 'Non Sulawesi';
            }

            // Inisialisasi struktur data
            if (!isset($groupedData[$region][$prov_id])) {
                $groupedData[$region][$prov_id] = [
                    'nama' => getNamaProvinsi($prov_id),
                    'jumlah' => 0,
                    'kabupaten' => []
                ];
            }

            if (!isset($groupedData[$region][$prov_id]['kabupaten'][$kab_id])) {
                $groupedData[$region][$prov_id]['kabupaten'][$kab_id] = [
                    'nama' => getNamaKabupaten($kab_id),
                    'jumlah' => 0,
                    'kecamatan' => []
                ];
            }

            if (!isset($groupedData[$region][$prov_id]['kabupaten'][$kab_id]['kecamatan'][$kec_id])) {
                $groupedData[$region][$prov_id]['kabupaten'][$kab_id]['kecamatan'][$kec_id] = [
                    'nama' => getNamaKecamatan($kec_id),
                    'jumlah' => 0,
                    'kelurahan' => []
                ];
            }

            if (!isset($groupedData[$region][$prov_id]['kabupaten'][$kab_id]['kecamatan'][$kec_id]['kelurahan'][$kel_id])) {
                $groupedData[$region][$prov_id]['kabupaten'][$kab_id]['kecamatan'][$kec_id]['kelurahan'][$kel_id] = [
                    'nama' => getNamaKelurahan($kel_id),
                    'laki-laki' => 0,
                    'perempuan' => 0,
                    'jumlah' => 0
                ];
            }

            // Tambahkan jumlah ke setiap level
            $jumlah = $data->jumlah_karyawan;
            $groupedData[$region][$prov_id]['jumlah'] += $jumlah;
            $groupedData[$region][$prov_id]['kabupaten'][$kab_id]['jumlah'] += $jumlah;
            $groupedData[$region][$prov_id]['kabupaten'][$kab_id]['kecamatan'][$kec_id]['jumlah'] += $jumlah;
            $groupedData[$region][$prov_id]['kabupaten'][$kab_id]['kecamatan'][$kec_id]['kelurahan'][$kel_id][$gender] += $jumlah;
            $groupedData[$region][$prov_id]['kabupaten'][$kab_id]['kecamatan'][$kec_id]['kelurahan'][$kel_id]['jumlah'] += $jumlah;
        }

        // Siapkan data chart kelurahan
        foreach ($groupedData as $region) {
            foreach ($region as $provinsi) {
                foreach ($provinsi['kabupaten'] as $kabupaten) {
                    foreach ($kabupaten['kecamatan'] as $kecamatan) {
                        foreach ($kecamatan['kelurahan'] as $kelurahan) {
                            $arr_jumlah_karyawan[] = $kelurahan['jumlah'];
                            $arr_nama_kelurahan[] = $kelurahan['nama'];
                        }
                    }
                }
            }
        }

        return $groupedData;

        return view('wilayah.index', [
            'arr_jumlah_karyawan' => $arr_jumlah_karyawan,
            'arr_nama_kelurahan' => $arr_nama_kelurahan,
            'array' => json_decode(json_encode($groupedData), true),
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
