<?php

namespace App\Http\Controllers\SelfService;

use App\Http\Controllers\Controller;
use App\Models\CutiIzin;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CutiTahunanController extends Controller
{
    public function index()
    {
        return view('user.cuti-tahunan.index');
    }

    public function store(Request $request)
    {
        try {
            $awal = new DateTime($request->tgl_mulai_cuti);
            $akhir = new DateTime($request->tgl_akhir_cuti);

            if ($akhir->diff($awal)->days > $request->sisa_cuti) {
                return back()->with('info', 'Hak cuti kamu tidak mencukupi...');
            }

            CutiIzin::create([
                'nik_karyawan' => $request->nik,
                'tanggal' => $request->tanggal_pengajuan,
                'keterangan' => $request->keterangan,
                'jumlah' => $akhir->diff($awal)->days == '0' ? '1' : $akhir->diff($awal)->days + '1',
                'tanggal_mulai' => $request->tgl_mulai_cuti,
                'tanggal_berakhir' => $request->tgl_akhir_cuti,
                'status_pemohon' => 'ya',
                'status_hod' => 'Menunggu',
                'status_hrd' => 'Menunggu',
                'status_penanggung_jawab' => 'Menunggu',
                'tipe' => 'cuti',
                'kategori_cuti' => 1
            ]);

            return back()->with('success', 'Berhasil melakukan pengajuan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan ' . $e->getMessage());
        }
    }
}
