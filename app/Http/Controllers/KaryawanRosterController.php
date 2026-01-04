<?php

namespace App\Http\Controllers;

use App\Imports\KaryawanRosterDeleteImport;
use App\Imports\KaryawanRosterImport;
use App\Models\CutiRoster;
use App\Models\employee;
use App\Models\KaryawanRoster;
use App\Models\Pengingat;
use App\Models\PeriodeKerjaRoster;
use App\Models\PeriodeRoster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class KaryawanRosterController extends Controller
{
    public function index(Request $request)
    {
        $periode = PeriodeRoster::orderBy('id', 'desc')->get();

        if ($request->filled('periode_id')) {

            $datas = KaryawanRoster::with('karyawan')
                ->join('periode_rosters', 'periode_rosters.id', '=', 'karyawan_rosters.periode_id')
                ->where('periode_rosters.id', $request->periode_id)
                ->get();

            return view('comben.karyawan_roster.index', compact('datas', 'periode'));
        }

        $datas = KaryawanRoster::with('karyawan')
            ->join('periode_rosters', 'periode_rosters.id', '=', 'karyawan_rosters.periode_id')
            ->get();

        return view('comben.karyawan_roster.index', compact('datas', 'periode'));
    }

    public function viewAdminDept(Request $request)
    {
        if ($request->filled('status_pengajuan')) {

            if ($request->status_pengajuan == 'Selesai') {
                $datas = Pengingat::with('periode')
                    ->leftjoin('employees', 'employees.nik', '=', 'pengingats.nik_karyawan')
                    ->leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
                    ->where('pengingats.flg_kirim', '2')->where('employees.divisi_id', Auth::user()->employee->divisi_id)
                    ->where('status_pengajuan', $request->status_pengajuan)
                    ->orderBy('tanggal_cuti', 'desc')
                    ->select('pengingats.*', 'employees.divisi_id')
                    ->get();
            }

            if ($request->status_pengajuan == 'Proses') {
                $datas = Pengingat::with('periode')
                    ->leftjoin('employees', 'employees.nik', '=', 'pengingats.nik_karyawan')
                    ->leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
                    ->where('pengingats.flg_kirim', '1')->where('employees.divisi_id', Auth::user()->employee->divisi_id)
                    ->where('status_pengajuan', $request->status_pengajuan)
                    ->orderBy('tanggal_cuti', 'desc')
                    ->select('pengingats.*', 'employees.divisi_id')
                    ->get();
            }

            if ($request->status_pengajuan == 'Jatuh Tempo') {
                $datas = Pengingat::with('periode')
                    ->leftjoin('employees', 'employees.nik', '=', 'pengingats.nik_karyawan')
                    ->leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
                    ->where('pengingats.flg_kirim', '1')->where('employees.divisi_id', Auth::user()->employee->divisi_id)
                    ->where('status_pengajuan', NULL)
                    ->where('tanggal_cuti', '<', date('Y-m-d'))
                    ->orderBy('tanggal_cuti', 'desc')
                    ->select('pengingats.*', 'employees.divisi_id')
                    ->get();
            }

            if ($request->status_pengajuan == 'Belum Pengajuan') {
                $datas = Pengingat::with('periode')
                    ->leftjoin('employees', 'employees.nik', '=', 'pengingats.nik_karyawan')
                    ->leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
                    ->where('pengingats.flg_kirim', '1')->where('employees.divisi_id', Auth::user()->employee->divisi_id)
                    ->where('status_pengajuan', NULL)
                    ->orderBy('tanggal_cuti', 'desc')
                    ->select('pengingats.*', 'employees.divisi_id')
                    ->get();
            }

            return view('admin-dept.pengingat.index', compact('datas'))->with('no');
        }

        $datas = Pengingat::with('periode')
            ->leftjoin('employees', 'employees.nik', '=', 'pengingats.nik_karyawan')
            ->leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
            ->where('pengingats.flg_kirim', '1')->where('employees.divisi_id', Auth::user()->employee->divisi_id)
            ->orderBy('tanggal_cuti', 'desc')
            ->select('pengingats.*', 'employees.divisi_id')
            ->get();

        return view('admin-dept.pengingat.index', compact('datas'))->with('no');
    }

    public function viewAdminDeptFormCuti($id)
    {
        $data = Pengingat::leftjoin('employees', 'employees.nik', '=', 'pengingats.nik_karyawan')
            ->join('divisis', 'divisis.id', '=', 'employees.divisi_id')
            ->join('departemens', 'departemens.id', '=', 'divisis.departemen_id')
            ->where('nik_karyawan', $id)
            ->where('pengingats.flg_kirim', '1')
            ->where('employees.divisi_id', Auth::user()->employee->divisi_id)
            ->select('pengingats.*', 'employees.divisi_id', 'employees.nama_karyawan', 'employees.nik', 'employees.no_telp', 'employees.posisi', 'departemens.departemen', 'divisis.nama_divisi')
            ->first();

        return view('admin-dept.form-cuti-roster', compact('data'))->with('no');
    }

    public function viewAdminPrint($id)
    {
        $data = employee::with('user')->leftjoin('cuti_roster', 'cuti_roster.nik_karyawan', '=', 'employees.nik')
            ->leftjoin('periode_kerja_roster', 'periode_kerja_roster.cuti_roster_id', '=', 'cuti_roster.id')
            ->where('cuti_roster.id', $id)
            ->select(DB::raw('*'))->first();

        if ($data->tanggal_pengajuan == null) {
            return back()->with('info', 'Formulir permohonan belum tersedia, lakukan pengajuan terlebih dahulu..');
        }

        $pdf = PDF::loadView('admin-dept.form-cuti-roster-print', compact('data'))->setPaper('a4');
        return $pdf->stream();
    }

    public function adminListPengajuan(Request $request)
    {
        if ($request->filled('status_pengajuan')) {
            $datas = CutiRoster::with('periode_kerja')->where('status_pengajuan', $request->status_pengajuan)->get();
        } else {
            $datas = CutiRoster::with('periode_kerja')->get();
        }

        return view('admin-dept.pengingat.permohonan', compact('datas'))->with('no');
    }

    public function importKaryawanRoster(Request $request)
    {
        Excel::import(new KaryawanRosterImport, $request->file('file'));
        return back();
    }

    public function importDeleteKaryawanRoster(Request $request)
    {
        Excel::import(new KaryawanRosterDeleteImport, $request->file('file'));
        return back()->with('success', 'Data Karyawan Roster Berhasil dhapus');
    }

    public function reminder(Request $request)
    {
        if ($request->filled('status_pengajuan')) {

            if ($request->status_pengajuan == 'Selesai') {
                $datas = Pengingat::with('periode', 'karyawan')->where('flg_kirim', '2')->where('status_pengajuan', $request->status_pengajuan)->orderBy('tanggal_cuti', 'desc')->get();
            }

            if ($request->status_pengajuan == 'Proses') {
                $datas = Pengingat::with('periode', 'karyawan')->where('flg_kirim', '1')->where('status_pengajuan', $request->status_pengajuan)->orderBy('tanggal_cuti', 'desc')->get();
            }

            if ($request->status_pengajuan == 'Jatuh Tempo') {
                $datas = Pengingat::with('periode', 'karyawan')->where('flg_kirim', '1')->where('tanggal_cuti', '<', date('Y-m-d'))->orderBy('tanggal_cuti', 'desc')->get();
            }

            if ($request->status_pengajuan == 'Belum Pengajuan') {
                $datas = Pengingat::with('periode', 'karyawan')->where('flg_kirim', '1')->where('status_pengajuan', NULL)->orderBy('tanggal_cuti', 'desc')->get();
            }

            return view('comben.pengingat.index', compact('datas'))->with('no');
        }
        $datas = Pengingat::with('periode', 'karyawan')->where('flg_kirim', '1')->orderBy('tanggal_cuti', 'desc')->get();
        return view('comben.pengingat.index', compact('datas'))->with('no');
    }

    public function pengingatPribadi()
    {
        $datas = Pengingat::orderBy('tanggal_cuti', 'ASC')->where('tanggal_cuti', '>=', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateString())))->where('flg_kirim', '1')->where('nik_karyawan', Auth::user()->employee->nik)->get();
        return view('comben.pengingat.pengingat-user', compact('datas'))->with('no');
    }

    public function updateStatusPengajuan(Request $request, $id)
    {
        Pengingat::where('id', $id)->update([
            'status_pengajuan' => $request->status_pengajuan,
            'flg_kirim' => $request->status_pengajuan == 'Selesai' ? '2' : '1'
        ]);
        return back()->with('success', 'Submission Status updated successfully');
    }

    public function rosterAktif()
    {
        return redirect('/kompensasi-dan-keuntungan/pengingat');
    }
}
