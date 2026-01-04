<?php

namespace App\Http\Controllers\SelfService;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\CutiRoster;
use App\Models\PeriodeKerjaRoster;
use App\Models\Pengingat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CutiRosterController extends Controller
{
    //
    public function index()
    {
        $kota = Kabupaten::all();
        return view('user.cuti-roster.index', compact('kota'));
    }

    public function store(Request $request)
    {
        $cek_file = CutiRoster::where('id', $request->nik_karyawan)->first();
        if ($request->hasFile('berkas_cuti')) {
            $upload = $request->file('berkas_cuti');
            $file_name = $request->nik_karyawan . ' - ' . $upload->getClientOriginalName();
            $path = public_path('/cuti-roster/' . $request->nik_karyawan . '/' . $request->tgl_pengajuan . '/');
            if (file_exists($path) && $cek_file) {
                unlink($path . $cek_file->file);
            }
            $upload->move($path, $file_name);
        }

        $bulan = date('m', strtotime(Carbon::now()));
        $bulan = bulan_romawi($bulan);

        $tahun = date('Y', strtotime(Carbon::now()));
        $jml_cuti = CutiRoster::count();
        $jml_cuti = no_urut_surat($jml_cuti);

        $nomor_surat = '02-' . $jml_cuti . '/BR/HRD-VDNI/' . $bulan . '/' . $tahun;

        DB::beginTransaction();

        if ($request->tipe_pilihan == '1') {
            $data_roster = CutiRoster::create([
                'nomor_surat' => $nomor_surat,
                'nik_karyawan' => $request->nik_karyawan,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'tanggal_pengajuan' => date('Y-m-d', strtotime($request->tanggal_pengajuan)),
                'tgl_mulai_cuti' => date('Y-m-d', strtotime($request->tgl_mulai_cuti)),
                'tgl_mulai_cuti_tahunan' => date('Y-m-d', strtotime($request->tgl_mulai_cuti_tahunan)),
                'tgl_mulai_off' => date('Y-m-d', strtotime($request->tgl_mulai_off)),
                'tgl_keberangkatan' => date('Y-m-d', strtotime($request->tanggal_keberangkatan)),
                'jam_keberangkatan' => $request->jam_keberangkatan,
                'kota_awal_keberangkatan' => $request->kota_awal_keberangkatan,
                'kota_tujuan_keberangkatan' => $request->kota_tujuan_keberangkatan,
                'catatan_penting_keberangkatan' => $request->catatan_penting_keberangkatan,
                'tgl_mulai_cuti_berakhir' => date('Y-m-d', strtotime($request->tgl_mulai_cuti_berakhir)),
                'tgl_mulai_cuti_tahunan_berakhir' => date('Y-m-d', strtotime($request->tgl_mulai_cuti_tahunan_berakhir)),
                'tgl_mulai_off_berakhir' => date('Y-m-d', strtotime($request->tgl_mulai_off_berakhir)),
                'tgl_kepulangan' => date('Y-m-d', strtotime($request->tgl_kepulangan)),
                'jam_kepulangan' => $request->jam_kepulangan,
                'kota_awal_kepulangan' => $request->kota_awal_kepulangan,
                'kota_tujuan_kepulangan' => $request->kota_tujuan_kepulangan,
                'catatan_penting_kepulangan' => $request->catatan_penting_kepulangan,
                'file' => $file_name ?? '',
                'status_pengajuan' => 'menunggu',
                'status_pengajuan_hrd' => 'menunggu'
            ]);
        } else {
            $data_roster = CutiRoster::create([
                'nomor_surat' => $nomor_surat,
                'nik_karyawan' => $request->nik_karyawan,
                'email' => $request->email,
                'tanggal_pengajuan' => date('Y-m-d', strtotime($request->tanggal_pengajuan)),
                'tgl_awal_kerja' => date('Y-m-d', strtotime($request->periode_awal)),
                'tgl_akhir_kerja' => date('Y-m-d', strtotime($request->periode_akhir)),
                'file' => $file_name ?? '',
                'status_pengajuan' => 'menunggu',
                'status_pengajuan_hrd' => 'menunggu'
            ]);
        }

        PeriodeKerjaRoster::create([
            'cuti_roster_id' => $data_roster->id,
            'periode_awal' => date('Y-m-d', strtotime($request->tgl_awal_kerja)),
            'periode_akhir' => date('Y-m-d', strtotime($request->tgl_akhir_kerja)),
            'satu' => $request->satu,
            'tanggal_satu' => date('Y-m-d', strtotime($request->tanggal_satu)),
            'dua' => $request->dua,
            'tanggal_dua' => date('Y-m-d', strtotime($request->tanggal_dua)),
            'tiga' => $request->tiga,
            'tanggal_tiga' => date('Y-m-d', strtotime($request->tanggal_tiga)),
            'empat' => $request->empat,
            'tanggal_empat' => date('Y-m-d', strtotime($request->tanggal_empat)),
            'lima' => $request->lima,
            'tanggal_lima' => date('Y-m-d', strtotime($request->tanggal_lima)),
            'tipe_rencana' => $request->tipe_pilihan,
            'alasan' => $request->alasan_pilihan,
        ]);

        Pengingat::where('id', $request->pengingat_id)->update([
            'status_pengajuan' => 'Proses'
        ]);
        DB::commit();

        return back()->with('success', 'Berhasil melakukan pengajuan cuti roster');
        try {
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan pada sistem');
        }
    }

    public function show($id)
    {
        $cuti = CutiRoster::join('employees', 'employees.nik', '=', 'cuti_roster.nik_karyawan')
            ->join('periode_kerja_roster', 'periode_kerja_roster.cuti_roster_id', '=', 'cuti_roster.id')
            ->orderBy('cuti_roster.id', 'desc')
            ->select('cuti_roster.*', 'employees.nama_karyawan',  'periode_kerja_roster.*')
            ->where('cuti_roster.id', $id)
            ->first();

        return view('account.permohonan-cuti-roster-detail', compact('cuti'));
    }

    public function destroy($id)
    {
        $data = CutiRoster::where('id', $id)->first();

        if ($data->status_pengajuan == 'diterima') {
            return back()->with('error', 'Oops, pengajuan sudah tidak dapat dihapus, dikarenakan sudah mendapat persetujuan');
        }

        PeriodeKerjaRoster::where('cuti_roster_id', $data->id)->delete();
        $data->delete();

        return back()->with('success', 'Data permohonan berhasil dihapus');
    }
}
