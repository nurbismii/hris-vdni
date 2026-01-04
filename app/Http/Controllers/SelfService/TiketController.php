<?php

namespace App\Http\Controllers\SelfService;

use App\Http\Controllers\Controller;
use App\Models\CutiRoster;
use Illuminate\Support\Facades\Auth;

class TiketController extends Controller
{
    public function index()
    {
        $datas = CutiRoster::where('nik_karyawan', Auth::user()->employee->nik)->get();
        return view('user.tiket.index', compact('datas'));
    }

    public function downloadTiketPesawat($id)
    {
        $data = CutiRoster::where('id', $id)->first();
        return response()->download(public_path('cuti-roster/' . $data->nik_karyawan . '/' . $data->tanggal_pengajuan . '/' . $data->tiket_pesawat));
    }
}
