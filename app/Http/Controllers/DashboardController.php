<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDashboardRequest;
use App\Mail\SendEmailVerification;
use App\Models\Absensi;
use App\Models\AuditTrail;
use App\Models\Contract;
use App\Models\Divisi;
use App\Models\employee;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\parameter_dashboard;
use App\Models\Provinsi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $data = parameter_dashboard::where('status', '1')
            ->latest()
            ->first();

        if (strtolower(Auth::user()->job->permission_role ?? '') == 'administrator') {

            $role = Auth::user()->job->permission_role ?? '';

            $bulan_sekarang = date('Y-m', strtotime(Carbon::now()));
            $tahun_sekarang = date('Y', strtotime(Carbon::now()));

            $tanggal_hari_ini = $bulan_sekarang . '-16';
            $tanggal_hari_ini = date('Y-m-d', strtotime("$tanggal_hari_ini -1 Month"));
            $bulan_depan = date('Y-m-d', strtotime("$tanggal_hari_ini +1 Month -1 Day"));

            $provinsi = Provinsi::all();

            $data_contract = Contract::all();
            $total_pwkt1_perbulan = Contract::where('tanggal_mulai_kontrak', 'like', '%' . $bulan_sekarang . '%')
                ->count();

            $total_pengguna = User::count();
            $terakhir_login = User::select('nik_karyawan', 'terakhir_login')
                ->orderBy('terakhir_login', 'desc')
                ->limit(6)
                ->get();

            $karyawan_resign = employee::select('tgl_resign', 'status_resign')
                ->where('status_resign', '!=', 'Aktif')
                ->get();

            $data_karyawan = employee::select('nik', 'status_resign', 'status_karyawan', 'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id', 'tgl_lahir')
                ->where('status_resign', 'Aktif')
                ->get();

            $total_karyawan_vdni = employee::where('status_resign', 'Aktif')->where('area_kerja', 'VDNI')
                ->count();

            $total_karyawan_vdnip = employee::where('status_resign', 'Aktif')->where('area_kerja', 'VDNIP')
                ->count();

            $req_awal_prd = $request->mulai_periode != '' ? $request->mulai_periode : $tanggal_hari_ini;
            $req_akhir_prd = $request->akhir_periode != '' ? $request->akhir_periode : $bulan_depan;

            $status_karyawan = employee::select('tgl_resign', 'status_resign')
                ->where('status_resign', '!=', 'Aktif')
                ->whereBetween('tgl_resign', array($req_awal_prd, $req_akhir_prd))
                ->get();

            /* Code for chart  */
            $chart_rekrut = getDataRekrut($data_contract, $tahun_sekarang);

            $chart_resign = getDataResign($karyawan_resign, $tahun_sekarang);

            $chart_status_kontrak = getDataStatusKaryawan($data_karyawan);

            $chart_status_karyawan = getDataStatus($status_karyawan);

            $umur_karyawan = getUmur($data_karyawan);
            /* Code for chart  end */

            $provinsi_id = $request->provinsi_id ?? '74';

            $kabupaten_id = $request->kabupaten ?? '7403';

            $kecamatan_id = $request->kecamatan ?? '7403105';

            $prov_res = Provinsi::where('id', $provinsi_id)->first();

            $kab_res = Kabupaten::where('id', $kabupaten_id)->first();

            $kec_res = Kecamatan::where('id', $kecamatan_id)->first();

            $check_request = employee::select('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')
                ->where('kabupaten_id', $kabupaten_id)
                ->where('status_resign', 'Aktif')
                ->first();

            if (!$check_request) {
                return redirect('dashboard')->with('error', 'Data dari yang kamu inginkan, belum tersedia');
            }

            $data_karyawan_by_kab = employee::join('master_kelurahan', 'master_kelurahan.id', '=', 'employees.kelurahan_id')
                ->where('kabupaten_id', $kabupaten_id)
                ->where('status_resign', 'Aktif')
                ->select('employees.provinsi_id', 'employees.kabupaten_id', 'employees.kecamatan_id', 'employees.kelurahan_id', 'master_kelurahan.kelurahan')
                ->get();

            $kelurahan = $data_karyawan_by_kab->pluck('kelurahan_id')->toArray();
            $nama = $data_karyawan_by_kab->pluck('kelurahan')->toArray();

            $res_kelurahan = getJumlahPekerjaByKelurahan($kelurahan, $nama);

            return $res_kelurahan;

            $jumlah_pekerja_by_kelurahan = jumlahPekerjaByKelurahan($res_kelurahan);

            $daftar_nama_kelurahan = daftarNamaKelurahan($res_kelurahan);

            $presensi_terakhir = Absensi::orderBy('created_at', 'desc')->limit(5)->get();

            return view('dashboard', compact(
                'data',
                'total_karyawan_vdni',
                'total_karyawan_vdnip',
                'total_pwkt1_perbulan',
                'total_pengguna',
                'role',
                'chart_rekrut',
                'chart_resign',
                'chart_status_kontrak',
                'chart_status_karyawan',
                'umur_karyawan',
                'terakhir_login',
                'jumlah_pekerja_by_kelurahan',
                'daftar_nama_kelurahan',
                'provinsi',
                'check_request',
                'presensi_terakhir',
                'req_awal_prd',
                'req_akhir_prd',
                'prov_res',
                'kab_res',
                'kec_res'
            ));
        }

        $day = date('D', strtotime(today()));

        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        $hari_ini = $dayList[$day];

        $karyawan = User::with('employee')->where('nik_karyawan', Auth::user()->nik_karyawan)->first();
        $divisi = Divisi::with('departemen')->where('id', $karyawan->employee->divisi_id)->first();

        return view('dashboard-user', compact('data', 'hari_ini', 'divisi'));
    }

    public function settingDashboard(Request $request)
    {
        try {
            $datas = parameter_dashboard::orderBy('id', 'DESC')->get();
            return view('customize_setting.dashboard.index', compact('datas'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function store(StoreDashboardRequest $request)
    {
        try {
            $status = $request->status;
            $data = parameter_dashboard::where('status', $status)->first();
            if ($data) {
                if ($data->status == '1') {
                    $data->where('status', $data->status)->update([
                        'status' => '0',
                    ]);
                    parameter_dashboard::create($request->all());
                    return back()->with('success', 'Content Dasboard has been added');
                }
            }
            parameter_dashboard::create($request->all());
            return back()->with('success', 'Content Dasboard has been added');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function update(StoreDashboardRequest $request, $id)
    {

        try {
            $data = parameter_dashboard::where('status', $request->status)->first();
            if ($data) {
                if ($data->status == '1') {
                    $data->where('status', $data->status)->update([
                        'status' => '0',
                    ]);
                }
            }
            parameter_dashboard::where('id', $id)->update([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'description' => $request->description,
                'status'  => $request->status
            ]);
            return back()->with('success', 'Content Dasboard has been updated');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function destroy($id)
    {
        try {
            parameter_dashboard::where('id', $id)->delete();
            return back()->with('success', 'Content Dashboard has been deleted');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function auditTrails()
    {
        try {
            $datas = AuditTrail::latest()->take(100)->get();
            return view('AuditTrails', compact('datas'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Something Wrong!');
        }
    }

    public function fetchKabupaten($id)
    {
        $kabupaten = Kabupaten::where('id_provinsi', $id)->get();
        return response()->json($kabupaten);
    }

    public function fetchKecamatan($id)
    {
        $kecamatan = Kecamatan::where('id_kabupaten', $id)->get();
        return response()->json($kecamatan);
    }

    public function fetchKelurahan($id)
    {
        $kecamatan = Kelurahan::where('id_kecamatan', $id)->get();
        return response()->json($kecamatan);
    }
}
