<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDashboardRequest;
use App\Models\AuditTrail;
use App\Models\Contract;
use App\Models\employee;
use App\Models\parameter_dashboard;
use App\Models\Pengingat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $role = Auth::user()->job->permission_role ?? '';
        $bulan_sekarang = date('Y-m', strtotime(Carbon::now()));
        $total_karyawan = employee::count();
        $total_pwkt1_perbulan = Contract::where('tanggal_mulai_kontrak', 'like', '%' . $bulan_sekarang . '%')->count();
        $total_pengguna = User::count();
        $data = parameter_dashboard::where('status', '1')->latest()->first();


        return view('dashboard', compact('data', 'total_karyawan', 'total_pwkt1_perbulan', 'total_pengguna', 'role'));
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
