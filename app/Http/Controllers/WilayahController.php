<?php

namespace App\Http\Controllers;

use App\Exports\WilayahExport;
use App\Models\employee;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $provinsi_all = Provinsi::all();

        // Default filter
        $area_kerja = $request->area_kerja ?? ['VDNI', 'VDNIP'];

        $arr_jumlah_karyawan = [];
        $arr_nama_kelurahan = [];
        $arr_region_data = []; // Menyimpan nama dan jumlah per region

        // Preload semua nama wilayah
        $nama_provinsi = Provinsi::pluck('provinsi', 'id')->toArray();
        $nama_kabupaten = Kabupaten::pluck('kabupaten', 'id')->toArray();
        $nama_kecamatan = Kecamatan::pluck('kecamatan', 'id')->toArray();
        $nama_kelurahan = Kelurahan::pluck('kelurahan', 'id')->toArray();

        // Ambil data karyawan per wilayah dan jenis kelamin
        $response = DB::table('employees')
            ->selectRaw('provinsi_id, kabupaten_id, kecamatan_id, kelurahan_id, LOWER(jenis_kelamin) as gender, COUNT(*) as jumlah_karyawan')
            ->where('status_resign', 'Aktif')
            ->whereIn('area_kerja', $area_kerja)
            ->groupBy('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id', 'gender')
            ->orderByDesc('jumlah_karyawan')
            ->get();

        // Struktur data terformat
        $groupedData = [
            'Sulawesi' => [],
            'Sulawesi Tenggara' => [],
            'Non Sulawesi' => [],
        ];

        $sulawesi_ids = ['71', '72', '73', '75', '76'];
        $sultra_ids = ['74'];

        // Proses data karyawan dan kelompokan berdasarkan wilayah
        foreach ($response as $data) {
            $prov_id = $data->provinsi_id;
            $kab_id = $data->kabupaten_id;
            $kec_id = $data->kecamatan_id;
            $kel_id = $data->kelurahan_id;
            $gender = $data->gender === 'l' || $data->gender === 'laki-laki' ? 'laki-laki' : ($data->gender === 'p' || $data->gender === 'perempuan' ? 'perempuan' : null);
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
                    'nama' => $nama_provinsi[$prov_id] ?? 'BELUM DIKETAHUI',
                    'jumlah' => 0,
                    'kabupaten' => []
                ];
            }

            if (!isset($groupedData[$region][$prov_id]['kabupaten'][$kab_id])) {
                $groupedData[$region][$prov_id]['kabupaten'][$kab_id] = [
                    'nama' => $nama_kabupaten[$kab_id] ?? 'BELUM DIKETAHUI',
                    'jumlah' => 0,
                    'kecamatan' => []
                ];
            }

            if (!isset($groupedData[$region][$prov_id]['kabupaten'][$kab_id]['kecamatan'][$kec_id])) {
                $groupedData[$region][$prov_id]['kabupaten'][$kab_id]['kecamatan'][$kec_id] = [
                    'nama' => $nama_kecamatan[$kec_id] ?? 'BELUM DIKETAHUI',
                    'jumlah' => 0,
                    'kelurahan' => []
                ];
            }

            if (!isset($groupedData[$region][$prov_id]['kabupaten'][$kab_id]['kecamatan'][$kec_id]['kelurahan'][$kel_id])) {
                $groupedData[$region][$prov_id]['kabupaten'][$kab_id]['kecamatan'][$kec_id]['kelurahan'][$kel_id] = [
                    'nama' => $nama_kelurahan[$kel_id] ?? 'BELUM DIKETAHUI',
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
        foreach ($groupedData as $regionKey => $region) {
            $regionJumlah = 0; // Variabel untuk menyimpan jumlah karyawan per region
            $regionNama = $regionKey; // Variabel untuk menyimpan nama region

            foreach ($region as $provinsi) {
                foreach ($provinsi['kabupaten'] as $kabupaten) {
                    foreach ($kabupaten['kecamatan'] as $kecamatan) {
                        foreach ($kecamatan['kelurahan'] as $kelurahan) {
                            // Menambahkan jumlah karyawan ke total per region
                            $arr_jumlah_karyawan[] = $kelurahan['jumlah'];
                            $arr_nama_kelurahan[] = $kelurahan['nama'];

                            // Menambahkan jumlah kelurahan ke jumlah region
                            $regionJumlah += $kelurahan['jumlah'];
                        }
                    }
                }
            }

            // Menyimpan nama dan jumlah per region
            $arr_region_data[] = [
                'region_nama' => $regionNama,
                'region_jumlah' => $regionJumlah
            ];
        }
        

        return view('wilayah.index', [
            'arr_jumlah_karyawan' => $arr_jumlah_karyawan,
            'arr_nama_kelurahan' => $arr_nama_kelurahan,
            'arr_region_data' => $arr_region_data, // Data nama region dan jumlah karyawan
            'array' => json_decode(json_encode($groupedData), true),
            'response' => $groupedData,
            'area_kerja' => $area_kerja,
            'provinsi_all' => $provinsi_all,
        ]);
    }


    public function exportExcel()
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
