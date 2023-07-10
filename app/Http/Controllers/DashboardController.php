<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDashboardRequest;
use App\Mail\SendEmailVerification;
use App\Models\Absensi;
use App\Models\AuditTrail;
use App\Models\Contract;
use App\Models\Divisi;
use App\Models\employee;
use App\Models\parameter_dashboard;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $data = parameter_dashboard::where('status', '1')->latest()->first();

        if (strtolower(Auth::user()->job->permission_role ?? '') == 'administrator') {

            $role = Auth::user()->job->permission_role ?? '';

            $bulan_sekarang = date('Y-m', strtotime(Carbon::now()));
            $tahun_sekarang = date('Y', strtotime(Carbon::now()));

            $total_karyawan = employee::where('status_resign', '!=', 'Ya')->count();
            $total_pwkt1_perbulan = Contract::where('tanggal_mulai_kontrak', 'like', '%' . $bulan_sekarang . '%')->count();
            $total_pengguna = User::count();
            $total_divisi = Divisi::count();

            $terakhir_login = User::select('nik_karyawan', 'terakhir_login')->orderBy('terakhir_login', 'desc')->limit(6)->get();
            $data_contract = Contract::all();

            $karyawan_resign = employee::select('tgl_resign', 'status_resign')->where('status_resign', 'Ya')->get();
            $data_karyawan = employee::select('nik', 'status_karyawan', 'provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id', 'tgl_lahir')->get();

            $chart_rekrut = getDataRekrut($data_contract, $tahun_sekarang);
            $chart_resign = getDataResign($karyawan_resign, $tahun_sekarang);
            $chart_status_karyawan = getDataStatusKaryawan($data_karyawan);

            $persentase = getDataStatusKaryawanPersentase($data_karyawan);
            $persen_pkwtt = $persentase['pkwtt'] / count($data_karyawan) * 100;
            $persen_pkwt = $persentase['pkwt'] / count($data_karyawan) * 100;
            $persen_training = $persentase['training'] / count($data_karyawan) * 100;

            $data_karyawan_provinsi = employee::select('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')->where('provinsi_id', '74')->first();
            $data_karyawan_kabupaten = employee::select('provinsi_id', 'kabupaten_id', 'kecamatan_id', 'kelurahan_id')->where('kabupaten_id', '7403')->get();

            $jumlah_daerah = getJumlahPekerjaDaerah($data_karyawan_kabupaten);
            $persen_morosi = $jumlah_daerah['morosi'] / count($data_karyawan_kabupaten) * 100;
            $persen_bondoala = $jumlah_daerah['bondoala'] / count($data_karyawan_kabupaten) * 100;
            $persen_kapioala = $jumlah_daerah['kapioala'] / count($data_karyawan_kabupaten) * 100;

            $umur_karyawan = getUmur($data_karyawan);

            $presensi_terakhir = Absensi::select('*')->orderBy('created_at', 'desc')->limit(10)->get();

            return view('dashboard', compact(
                'data',
                'total_karyawan',
                'total_pwkt1_perbulan',
                'total_pengguna',
                'role',
                'total_divisi',
                'chart_rekrut',
                'chart_resign',
                'chart_status_karyawan',
                'persen_morosi',
                'persen_bondoala',
                'persen_kapioala',
                'persen_pkwtt',
                'persen_pkwt',
                'persen_training',
                'umur_karyawan',
                'terakhir_login',
                'data_karyawan_kabupaten',
                'presensi_terakhir'
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

        $datas = User::with('employee')->where('nik_karyawan', Auth::user()->nik_karyawan)->first();
        $divisi = Divisi::with('departemen')->where('id', $datas->employee->divisi_id)->first();

        return view('dashboard-user', compact('hari_ini', 'divisi'));
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
}
