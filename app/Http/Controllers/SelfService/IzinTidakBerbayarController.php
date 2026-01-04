<?php

namespace App\Http\Controllers\SelfService;

use App\Http\Controllers\Controller;
use App\Models\CutiIzin;
use DateTime;
use Illuminate\Http\Request;

class IzinTidakBerbayarController extends Controller
{
    public function index()
    {
        return view('user.izin-tidak-berbayar.index');
    }

    public function store(Request $request)
    {
        $awal = new DateTime($request->tgl_mulai_cuti);
        $akhir = new DateTime($request->tgl_akhir_cuti);

        CutiIzin::create([
            'nik_karyawan' => $request->nik,
            'tanggal' => $request->tanggal_pengajuan,
            'keterangan' => $request->keterangan,
            'jumlah' => $akhir->diff($awal)->days == '0' ? '1' : $akhir->diff($awal)->days,
            'tanggal_mulai' => $request->tgl_mulai_cuti,
            'tanggal_berakhir' => $request->tgl_akhir_cuti,
            'status_pemohon' => 'ya',
            'tipe' => 'izin tidak dibayarkan',
        ]);

        return back()->with('success', 'Berhasil melakukan pengajuan');
    }
}
