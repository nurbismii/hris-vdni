<?php

namespace App\Http\Controllers;

use App\Imports\KaryawanRosterDeleteImport;
use App\Imports\KaryawanRosterImport;
use App\Models\Pengingat;
use App\Models\PeriodeRoster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $rosters = [];
        $periode = [];
        $list_periode = PeriodeRoster::orderBy('id', 'ASC')->limit(3)->get();
        if ($request->filled('awal_periode')) {
            $cek_filter = $request->akhir_periode - $request->awal_periode;
            if ($cek_filter == 1) {
                $datas = PeriodeRoster::with('karyawanRoster', 'pengingat')->where([
                    'awal_periode' => $request->awal_periode,
                    'akhir_periode' => $request->akhir_periode,
                ])->get();

                foreach ($datas as $data) {
                    $periode = [
                        'id' => $data->id,
                        'awal_periode' => $data->awal_periode,
                        'akhir_periode' => $data->akhir_periode,
                    ];
                    $pengingat = [
                        'periode_id' => $data->pengingat->periode_id ?? null,
                    ];
                    $rosters = $data->karyawanRoster;
                }
                return view('comben.karyawan_roster.index', compact('periode', 'rosters', 'list_periode', 'pengingat'));
            }
        }

        $datas = PeriodeRoster::with('karyawanRoster', 'pengingat')->where([
            'awal_periode' => date('Y', strtotime("-1 year")),
            'akhir_periode' => date('Y', strtotime(Carbon::now()))
        ])->get();

        foreach ($datas as $data) {
            $periode = [
                'id' => $data->id,
                'awal_periode' => $data->awal_periode,
                'akhir_periode' => $data->akhir_periode,
            ];
            $pengingat = [
                'periode_id' => $data->pengingat->periode_id ?? null,
            ];

            $rosters = $data->karyawanRoster;
        }
        return view('comben.karyawan_roster.index', compact('periode', 'rosters', 'list_periode', 'pengingat'));
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
        // $datas = Pengingat::with('periode')->where('tanggal_cuti', '>=', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateString())))->where('flg_kirim', '1')->orderBy('tanggal_cuti', 'ASC')->get();
        if ($request->filled('status_pengajuan')) {
            if ($request->status_pengajuan == 'Selesai') {
                $datas = Pengingat::with('periode')->where('flg_kirim', '2')->where('status_pengajuan', $request->status_pengajuan)->orderBy('tanggal_cuti', 'desc')->limit(100)->get();
            }
            if ($request->status_pengajuan == 'Proses') {
                $datas = Pengingat::with('periode')->where('flg_kirim', '1')->where('status_pengajuan', $request->status_pengajuan)->orderBy('tanggal_cuti', 'desc')->limit(100)->get();
            }
            if ($request->status_pengajuan == 'Jatuh Tempo') {
                $datas = Pengingat::with('periode')->where('flg_kirim', '1')->where('tanggal_cuti', '<', date('Y-m-d'))->orderBy('tanggal_cuti', 'desc')->limit(100)->get();
            }
            if ($request->status_pengajuan == 'Belum Pengajuan') {
                $datas = Pengingat::with('periode')->where('flg_kirim', '1')->where('status_pengajuan', NULL)->orderBy('tanggal_cuti', 'desc')->limit(100)->get();
            }
            return view('comben.pengingat.index', compact('datas'))->with('no');
        }
        $datas = Pengingat::with('periode')->where('flg_kirim', '1')->orderBy('tanggal_cuti', 'desc')->limit(100)->get();
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
