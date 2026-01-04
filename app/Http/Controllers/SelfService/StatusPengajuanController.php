<?php

namespace App\Http\Controllers\SelfService;

use App\Http\Controllers\Controller;
use App\Models\CutiIzin;
use App\Models\CutiRoster;
use Illuminate\Support\Facades\Auth;

class StatusPengajuanController extends Controller
{
    //
    public function index()
    {
        $datas = CutiIzin::orderBy('created_at', 'DESC')->where('nik_karyawan', Auth::user()->nik_karyawan)->limit(6)->get();
        return view('user.status-pengajuan.pengajuan', compact('datas'));
    }

    public function statusRoster()
    {
        $cuti = CutiRoster::join('employees', 'employees.nik', '=', 'cuti_roster.nik_karyawan')
            ->join('periode_kerja_roster', 'periode_kerja_roster.cuti_roster_id', '=', 'cuti_roster.id')
            ->orderBy('cuti_roster.id', 'desc')
            ->select('cuti_roster.*', 'employees.nama_karyawan',  'periode_kerja_roster.tipe_rencana')
            ->get();

        return view('user.status-pengajuan.cuti-roster', compact('cuti'));
    }
}
