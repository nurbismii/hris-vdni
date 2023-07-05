<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDashboardRequest;
use App\Mail\SendEmailVerification;
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
        if (strtolower(Auth::user()->job->permission_role ?? '') == 'administrator') {
            $role = Auth::user()->job->permission_role ?? '';
            $bulan_sekarang = date('Y-m', strtotime(Carbon::now()));
            $tahun_sekarang = date('Y', strtotime(Carbon::now()));
            $total_karyawan = employee::count();
            $total_pwkt1_perbulan = Contract::where('tanggal_mulai_kontrak', 'like', '%' . $bulan_sekarang . '%')->count();
            $total_pengguna = User::count();
            $total_divisi = Divisi::count();
            $data = parameter_dashboard::where('status', '1')->latest()->first();
            $data_contract = Contract::all();
            $karyawan_resign = employee::where('status_resign', 'Ya')->get();

            foreach ($karyawan_resign as $ks) {
                $validation1[] = date('Y', strtotime($ks->tgl_resign));
            }

            foreach ($karyawan_resign as $ks) {
                $resign_record[] = date('m', strtotime($ks->tgl_resign));
            }

            for ($i = 0; $i < count($resign_record); $i++) :
                if ($validation1[$i] == $tahun_sekarang) :
                    $jan1[] = $resign_record[$i] == "01" ? $resign_record[$i] : [];
                    $feb1[] = $resign_record[$i] == "02" ? $resign_record[$i] : [];
                    $maret1[] = $resign_record[$i] == "03" ? $resign_record[$i] : [];
                    $april1[] = $resign_record[$i] == "04" ? $resign_record[$i] : [];
                    $mei1[] = $resign_record[$i] == "05" ? $resign_record[$i] : [];
                    $juni1[] = $resign_record[$i] == "06" ? $resign_record[$i] : [];
                    $juli1[] = $resign_record[$i] == "07" ? $resign_record[$i] : [];
                    $agust1[] = $resign_record[$i] == "08" ? $resign_record[$i] : [];
                    $sept1[] = $resign_record[$i] == "09" ? $resign_record[$i] : [];
                    $okt1[] = $resign_record[$i] == "10" ? $resign_record[$i] : [];
                    $nov1[] = $resign_record[$i] == "11" ? $resign_record[$i] : [];
                    $dec1[] = $resign_record[$i] == "12" ? $resign_record[$i] : [];
                endif;
            endfor;

            $chart_resign = [
                count(array_filter($jan1)),
                count(array_filter($feb1)),
                count(array_filter($maret1)),
                count(array_filter($april1)),
                count(array_filter($mei1)),
                count(array_filter($juni1)),
                count(array_filter($juli1)),
                count(array_filter($agust1)),
                count(array_filter($sept1)),
                count(array_filter($okt1)),
                count(array_filter($nov1)),
                count(array_filter($dec1))
            ];

            foreach ($data_contract as $d) {
                $validation[] = date('Y', strtotime($d->tanggal_mulai_kontrak));
            }

            foreach ($data_contract as $d) {
                $rekrutmen_record[] = date('m', strtotime($d->tanggal_mulai_kontrak));
            }

            for ($i = 0; $i < count($rekrutmen_record); $i++) :
                if ($validation[$i] == $tahun_sekarang) :
                    $jan[] = $rekrutmen_record[$i] == "01" ? $rekrutmen_record[$i] : [];
                    $feb[] = $rekrutmen_record[$i] == "02" ? $rekrutmen_record[$i] : [];
                    $maret[] = $rekrutmen_record[$i] == "03" ? $rekrutmen_record[$i] : [];
                    $april[] = $rekrutmen_record[$i] == "04" ? $rekrutmen_record[$i] : [];
                    $mei[] = $rekrutmen_record[$i] == "05" ? $rekrutmen_record[$i] : [];
                    $juni[] = $rekrutmen_record[$i] == "06" ? $rekrutmen_record[$i] : [];
                    $juli[] = $rekrutmen_record[$i] == "07" ? $rekrutmen_record[$i] : [];
                    $agust[] = $rekrutmen_record[$i] == "08" ? $rekrutmen_record[$i] : [];
                    $sept[] = $rekrutmen_record[$i] == "09" ? $rekrutmen_record[$i] : [];
                    $okt[] = $rekrutmen_record[$i] == "10" ? $rekrutmen_record[$i] : [];
                    $nov[] = $rekrutmen_record[$i] == "11" ? $rekrutmen_record[$i] : [];
                    $dec[] = $rekrutmen_record[$i] == "12" ? $rekrutmen_record[$i] : [];
                endif;
            endfor;

            $chart_rekrut = [
                count(array_filter($jan)),
                count(array_filter($feb)),
                count(array_filter($maret)),
                count(array_filter($april)),
                count(array_filter($mei)),
                count(array_filter($juni)),
                count(array_filter($juli)),
                count(array_filter($agust)),
                count(array_filter($sept)),
                count(array_filter($okt)),
                count(array_filter($nov)),
                count(array_filter($dec))
            ];
            return view('dashboard', compact('data', 'total_karyawan', 'total_pwkt1_perbulan', 'total_pengguna', 'role', 'total_divisi', 'chart_rekrut', 'chart_resign'));
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
