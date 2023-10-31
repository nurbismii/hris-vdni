<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Divisi;
use App\Models\employee;
use App\Models\LokasiAbsen;
use App\Repositories\Absensi\AbsensiRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public $absensiRepo;

    public function __construct(AbsensiRepository $absensiRepo)
    {
        $this->absensiRepo = $absensiRepo;
    }

    public function index()
    {
        $datas = $this->absensiRepo->getAbsensiByNik();

        $absen_hari_ini = $this->absensiRepo->getAbsensiHariIni();
        $jam_masuk = $absen_hari_ini->jam_masuk ?? 'Belum Absen';
        $jam_pulang = $absen_hari_ini->jam_pulang ?? 'Belum Absen';

        return view('kehadiran.index', compact('datas', 'jam_pulang', 'jam_masuk', 'absen_hari_ini'))->with('no');
    }

    public function store(Request $request)
    {
        $check_karyawan = $this->absensiRepo->checkKaryawan($request->nik_karyawan);

        if (!$check_karyawan) {
            return back()->with('error', 'Data karyawan tidak dapat ditemukan');
        }

        $divisi = Divisi::where('id', $check_karyawan->divisi_id)->first();

        if (!$divisi) {
            return back()->with('error', 'Divisi kamu tidak dapat ditemukan, silahkan laporkan masalah ini ke HRD');
        }

        $lokasi_absen = LokasiAbsen::where('divisi_id', $divisi->id)->first();

        if (!$lokasi_absen)
            return back()->with('error', 'Lokasi absen tidak dapat ditemukan');

        if ($lokasi_absen->jarak_toleransi <= '50') {
            $lokasi_absen->jarak_toleransi = 50;
        }

        $jarak_absen = Controller::getDistance($lokasi_absen->lat, $lokasi_absen->long, $request->lat, $request->lng);

        if ($jarak_absen > $lokasi_absen->jarak_toleransi) {
            $msg = ($jarak_absen - $lokasi_absen->jarak_toleransi);
            return back()->with('error', 'Posisi kurang ' . $msg . ' meter dari titik absen');
        }

        $cek_absen = Absensi::where('nik_karyawan', $request->nik_karyawan)->whereDate('created_at', Carbon::today())->first();

        if (!$cek_absen) {
            Absensi::create([
                'nik_karyawan' => $request->nik_karyawan,
                'jam_masuk' => date('Y-m-d H:i:s', strtotime(Carbon::now()))
            ]);
            return back()->with('success', 'Berhasil melakukan absen masuk');
        }

        return back()->with('warning', 'Kamu sudah melakukan absen masuk');
    }

    public function update(Request $request, $id)
    {
        $karyawan = $this->absensiRepo->checkKaryawan($request->nik_karyawan);

        if (!$karyawan) {
            return back()->with('error', 'Data karyawan tidak dapat ditemukan');
        }

        $divisi = Divisi::where('id', $karyawan->divisi_id)->first();

        if (!$divisi) {
            return back()->with('error', 'Divisi kamu tidak dapat ditemukan, silahkan laporkan masalah ini ke HRD');
        }

        $lokasi_absen = LokasiAbsen::where('divisi_id', $divisi->id)->first();

        if (!$lokasi_absen)
            return back()->with('error', 'Lokasi absen tidak dapat ditemukan');

        if ($lokasi_absen->jarak_toleransi <= '50') {
            $lokasi_absen->jarak_toleransi = 50;
        }

        $jarak_absen = Controller::getDistance($lokasi_absen->lat, $lokasi_absen->long, $request->lat, $request->lng);

        if ($jarak_absen >= $lokasi_absen->jarak_toleransi) {
            $msg = ($jarak_absen - $lokasi_absen->jarak_toleransi);
            return back()->with('error', 'Posisi kurang ' . $msg . ' meter dari titik absen');
        }

        $cek_absen = Absensi::where('id', $id)->first();

        if (!$cek_absen) {
            return back()->with('info', 'Kamu sudah melakukan absen keluar');
        }

        if ($cek_absen->jam_keluar < '16:00:00') {
            Absensi::where('id', $id)->update([
                'nik_karyawan' => $request->nik_karyawan,
                'jam_pulang' => date('Y-m-d H:i:s', strtotime(Carbon::now()))
            ]);
            return back()->with('success', 'Berhasil melakukan absen keluar');
        }
    }

    public function destroy(Absensi $absensi)
    {
        //
    }
}
