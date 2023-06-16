<?php

namespace App\Http\Controllers;

use App\Imports\KaryawanRosterDeleteImport;
use App\Imports\KaryawanRosterImport;
use App\Models\KaryawanRoster;
use App\Models\Pengingat;
use App\Models\PeriodeRoster;
use Carbon\Carbon;
use DateTime;
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
        if ($request->filled('awal_periode')) {
            $list_periode = PeriodeRoster::orderBy('id', 'DESC')->get();
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
                $url = prev_segments(url()->current());
                return view('karyawan_roster.index', compact('periode', 'rosters', 'list_periode', 'pengingat'));
            }
        }

        $list_periode = PeriodeRoster::orderBy('id', 'DESC')->get();
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
        return view('karyawan_roster.index', compact('periode', 'rosters', 'list_periode', 'pengingat'));
    }

    public function importKaryawanRoster(Request $request)
    {
        Excel::import(new KaryawanRosterImport, $request->file('file'));
        return back()->with('success', 'Data Karyawan Roster Berhasil ditambahkan');
    }

    public function importDeleteKaryawanRoster(Request $request)
    {
        Excel::import(new KaryawanRosterDeleteImport, $request->file('file'));
        return back()->with('success', 'Data Karyawan Roster Berhasil dhapus');
    }

    public function pengingat(Request $request)
    {
        $minggu_pertama = [];
        $minggu_kedua = [];
        $minggu_ketiga = [];
        $minggu_keempat = [];
        $minggu_kelima = [];

        $data_pengingat = Pengingat::where('periode_id', $request->periode)->first();

        if ($data_pengingat) {
            return back()->with('error', 'Periode sudah terdaftar dalam pengingat');
        }

        $data_periode = PeriodeRoster::where('id', $request->periode)->first();

        $data_minggu_pertama = KaryawanRoster::where('periode_id', $request->periode)->get(['id', 'nik_karyawan', 'periode_id', 'minggu_pertama']);
        $data_minggu_kedua = KaryawanRoster::where('periode_id', $request->periode)->get(['id', 'nik_karyawan', 'periode_id', 'minggu_kedua']);
        $data_minggu_ketiga = KaryawanRoster::where('periode_id', $request->periode)->get(['id', 'nik_karyawan', 'periode_id', 'minggu_ketiga']);
        $data_minggu_keempat = KaryawanRoster::where('periode_id', $request->periode)->get(['id', 'nik_karyawan', 'periode_id', 'minggu_keempat']);
        $data_minggu_kelima = KaryawanRoster::where('periode_id', $request->periode)->get(['id', 'nik_karyawan', 'periode_id', 'minggu_kelima']);

        foreach ($data_minggu_pertama as $row) {
            $minggu_pertama[] =  [
                'roster_id' => $row->id,
                'nik_karyawan' => $row->nik_karyawan,
                'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti pertama periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode,
                'periode_id' => $row->periode_id,
                'periode_mingguan' => '1',
                'tanggal_cuti' => $row->minggu_pertama,
                'flg_kirim' => 0
            ];
        }

        foreach ($data_minggu_kedua as $row) {
            $minggu_kedua[] =  [
                'roster_id' => $row->id,
                'nik_karyawan' => $row->nik_karyawan,
                'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti kedua periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode,
                'periode_id' => $row->periode_id,
                'periode_mingguan' => '2',
                'tanggal_cuti' => $row->minggu_kedua,
                'flg_kirim' => 0
            ];
        }

        foreach ($data_minggu_ketiga as $row) {
            $minggu_ketiga[] =  [
                'roster_id' => $row->id,
                'nik_karyawan' => $row->nik_karyawan,
                'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti ketiga periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode,
                'periode_id' => $row->periode_id,
                'periode_mingguan' => '3',
                'tanggal_cuti' => $row->minggu_ketiga,
                'flg_kirim' => 0
            ];
        }
        foreach ($data_minggu_keempat as $row) {
            $minggu_keempat[] =  [
                'roster_id' => $row->id,
                'nik_karyawan' => $row->nik_karyawan,
                'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti keempat periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode,
                'periode_id' => $row->periode_id,
                'periode_mingguan' => '4',
                'tanggal_cuti' => $row->minggu_keempat,
                'flg_kirim' => 0
            ];
        }

        foreach ($data_minggu_kelima as $row) {
            $minggu_kelima[] =  [
                'roster_id' => $row->id,
                'nik_karyawan' => $row->nik_karyawan,
                'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti kelima periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode,
                'periode_id' => $row->periode_id,
                'periode_mingguan' => '5',
                'tanggal_cuti' => $row->minggu_kelima,
                'flg_kirim' => 0
            ];
        }

        if (count($minggu_pertama) > 0) {
            $batch_pengingat = array_merge($minggu_pertama, $minggu_kedua, $minggu_ketiga, $minggu_keempat, $minggu_kelima);
            foreach (array_chunk($batch_pengingat, 300) as $chunk) {
                Pengingat::insert($chunk);
            }
            return redirect('roster')->with('success', 'Pengingat untuk periode ' . $data_periode->awal_periode . ' - ' . $data_periode->akhir_periode);
        }
        return back()->with('warning', 'Data di periode ini ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode . ' belum tersedia, silahkan import terlebih dahulu');

        try {
        } catch (\Throwable $e) {
            return back()->with('error', 'Upps, Terjadi kesalahan');
        }
    }

    public function reminder(Request $request)
    {
        // $datas = Pengingat::with('periode')->where('tanggal_cuti', '>=', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateString())))->where('flg_kirim', '1')->orderBy('tanggal_cuti', 'ASC')->get();
        if ($request->filled('status_pengajuan')) {
            if ($request->status_pengajuan == 'Selesai') {
                $datas = Pengingat::with('periode')->where('flg_kirim', '2')->where('status_pengajuan', $request->status_pengajuan)->orderBy('tanggal_cuti', 'desc')->get();
            }
            if ($request->status_pengajuan == 'Proses') {
                $datas = Pengingat::with('periode')->where('flg_kirim', '1')->where('status_pengajuan', $request->status_pengajuan)->orderBy('tanggal_cuti', 'desc')->get();
            }
            if ($request->status_pengajuan == 'Jatuh Tempo') {
                $datas = Pengingat::with('periode')->where('flg_kirim', '1')->where('tanggal_cuti', '<=', date('Y-m-d'))->orderBy('tanggal_cuti', 'desc')->get();
            }
            if ($request->status_pengajuan == 'Belum Pengajuan') {
                $datas = Pengingat::with('periode')->where('flg_kirim', '1')->where('status_pengajuan', NULL)->orderBy('tanggal_cuti', 'desc')->get();
            }
            return view('pengingat.index', compact('datas'))->with('no');
        }
        $datas = Pengingat::with('periode')->where('flg_kirim', '1')->orderBy('tanggal_cuti', 'desc')->get();
        return view('pengingat.index', compact('datas'))->with('no');
    }

    public function pengingatPribadi(Request $request)
    {
        if ($request->filled('status_pengajuan')) {
            if ($request->status_pengajuan == 'Selesai') {
                $datas = Pengingat::with('periode')->where('flg_kirim', '2')->where('status_pengajuan', $request->status_pengajuan)->where('nik_karyawan', Auth::user()->employee->nik)->orderBy('tanggal_cuti', 'desc')->get();
            }
            if ($request->status_pengajuan == 'Proses') {
                $datas = Pengingat::with('periode')->where('flg_kirim', '1')->where('status_pengajuan', $request->status_pengajuan)->where('nik_karyawan', Auth::user()->employee->nik)->rderBy('tanggal_cuti', 'desc')->get();
            }
            if ($request->status_pengajuan == 'Jatuh Tempo') {
                $datas = Pengingat::with('periode')->where('flg_kirim', '1')->where('tanggal_cuti', '<=', date('Y-m-d'))->where('nik_karyawan', Auth::user()->employee->nik)->orderBy('tanggal_cuti', 'desc')->get();
            }
            if ($request->status_pengajuan == 'Belum Pengajuan') {
                $datas = Pengingat::with('periode')->where('flg_kirim', '1')->where('status_pengajuan', NULL)->where('nik_karyawan', Auth::user()->employee->nik)->orderBy('tanggal_cuti', 'desc')->get();
            }
            return view('pengingat.index', compact('datas'))->with('no');
        }
        $datas = Pengingat::with('periode')->where('flg_kirim', '1')->where('nik_karyawan', Auth::user()->employee->nik)->orderBy('tanggal_cuti', 'desc')->get();
        return view('pengingat.index', compact('datas'))->with('no');
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
