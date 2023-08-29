<?php

namespace App\Http\Controllers;

use App\Imports\KaryawanRosterDeleteImport;
use App\Imports\KaryawanRosterImport;
use App\Models\KaryawanRoster;
use App\Models\Pengingat;
use App\Models\PeriodeRoster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanRosterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $periode = PeriodeRoster::orderBy('id', 'desc')->get();

        if ($request->filled('periode_id')) {

            $datas = KaryawanRoster::with('karyawan')
                ->leftjoin('periode_rosters', 'periode_rosters.id', '=', 'karyawan_rosters.periode_id')
                ->where('periode_rosters.id', $request->periode_id)
                ->get();

            return view('comben.karyawan_roster.index', compact('datas', 'periode'));
        }

        $datas = KaryawanRoster::with('karyawan')
            ->leftjoin('periode_rosters', 'periode_rosters.id', '=', 'karyawan_rosters.periode_id')
            ->get();

        return view('comben.karyawan_roster.index', compact('datas', 'periode'));
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
        return back()->with('success', 'Status Pengajuan berhasil diperbarui');
    }

    public function rosterAktif()
    {
        return redirect('roster/daftar-pengingat');
    }
}
