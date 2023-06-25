<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Divisi;
use App\Models\employee;
use App\Models\LokasiAbsen;
use App\Models\WaktuAbsen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{

    public function index()
    {
        $absen_hari_ini = Absensi::where('nik_karyawan', Auth::user()->employee->nik)->whereDate('created_at', Carbon::today())->latest()->first();
        $datas = Absensi::orderBy('created_at', 'DESC')->where('nik_karyawan', Auth::user()->employee->nik)->get();
        $jam_masuk = $absen_hari_ini->jam_masuk ?? 'Belum Absen';
        $jam_pulang = $absen_hari_ini->jam_pulang ?? 'Belum Absen';
        $waktu_absen = WaktuAbsen::all();

        if (!$absen_hari_ini) {
            $cek_absen = '';
        }

        return view('kehadiran.index', compact('datas', 'jam_pulang', 'jam_masuk', 'absen_hari_ini'))->with('no');
    }

    public function store(Request $request)
    {
        $karyawan = employee::where('nik', $request->nik_karyawan)->first();
        if ($karyawan) {
            $divisi = Divisi::where('id', $karyawan->divisi_id)->first();
            if ($divisi) {
                $lokasi_absen = LokasiAbsen::where('divisi_id', $divisi->id)->first();
                if (!$lokasi_absen)
                    return back()->with('error', 'Lokasi absen tidak dapat ditemukan');
                $jarak_absen = Controller::getDistance($lokasi_absen->lat, $lokasi_absen->long, $request->lat, $request->lng);
                if ($jarak_absen > $lokasi_absen->jarak_toleransi) {
                    $msg = $lokasi_absen->jarak_toleransi - $jarak_absen;
                    return back()->with('error', 'Posisi kurang ' . $msg . ' meter dari titik absen');
                }
                $cek_absen = Absensi::where('nik_karyawan', $request->nik_karyawan)->whereDate('created_at', Carbon::today())->first();
                if (!$cek_absen) {
                    Absensi::create([
                        'nik_karyawan' => $request->nik_karyawan,
                        'jam_masuk' => date('H:i:s', strtotime(Carbon::now()))
                    ]);
                    return back()->with('success', 'Berhasil melakukan absen');
                }
                return back()->with('warning', 'Kamu sudah melakukan absen masuk');
            }
            return back()->with('error', 'Divisi kamu tidak dapat ditemukan, silahkan laporkan masalah ini ke HRD');
        }
        return back()->with('error', 'Terjadi kesalahan!');
    }

    public function update(Request $request, $id)
    {
        $karyawan = employee::where('nik', $request->nik_karyawan)->first();
        if ($karyawan) {
            $divisi = Divisi::where('id', $karyawan->divisi_id)->first();
            if ($divisi) {
                $lokasi_absen = LokasiAbsen::where('divisi_id', $divisi->id)->first();
                $jarak_absen = Controller::getDistance($lokasi_absen->lat, $lokasi_absen->long, $request->lat, $request->lng);
                if ($jarak_absen > 0.1) {
                    return back()->with('error', 'Posisi kamu terlalu jauh dari lokasi absen');
                }
                $cek_absen = Absensi::where('id', $id)->first();
                if (!$cek_absen->jam_keluar) {
                    Absensi::where('id', $id)->update([
                        'nik_karyawan' => $request->nik_karyawan,
                        'jam_pulang' => date('H:i:s', strtotime(Carbon::now()))
                    ]);
                    return back()->with('success', 'Berhasil melakukan absen');
                }
                return back()->with('info', 'Kamu sudah melakukan absen masuk');
            }
            return back()->with('error', 'Divisi kamu tidak dapat ditemukan, silahkan laporkan masalah ini ke HRD');
        }
        return back()->with('error', 'Terjadi kesalahan!');
    }

    public function destroy(Absensi $absensi)
    {
        //
    }
}
