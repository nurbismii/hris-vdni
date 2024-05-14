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
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

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

    public function pengajuanCutiRoster(Request $request)
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
                'tgl_awal_kerja' => date('Y-m-d', strtotime($request->tgl_awal_kerja)),
                'tgl_akhir_kerja' => date('Y-m-d', strtotime($request->tgl_akhir_kerja)),
                'file' => $file_name ?? '',
                'status_pengajuan' => 'menunggu'
            ]);
        }

        PeriodeKerjaRoster::create([
            'cuti_roster_id' => $data_roster->id,
            'periode_awal' => date('Y-m-d', strtotime($request->periode_awal)),
            'periode_akhir' => date('Y-m-d', strtotime($request->periode_akhir)),
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
        return redirect('roster/daftar-pengingat');
    }

    public function pengajuanCutiRosterDetail($id)
    {
        $cuti = CutiRoster::join('employees', 'employees.nik', '=', 'cuti_roster.nik_karyawan')
            ->join('periode_kerja_roster', 'periode_kerja_roster.cuti_roster_id', '=', 'cuti_roster.id')
            ->orderBy('cuti_roster.id', 'desc')
            ->select('cuti_roster.*', 'employees.nama_karyawan',  'periode_kerja_roster.*')
            ->where('cuti_roster.id', $id)
            ->first();

        return view('account.permohonan-cuti-roster-detail', compact('cuti'));
    }

    public function pengajuanCutiRosterHapus($id)
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
