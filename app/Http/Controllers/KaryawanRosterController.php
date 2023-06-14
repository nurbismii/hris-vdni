<?php

namespace App\Http\Controllers;

use App\Imports\KaryawanRosterImport;
use App\Models\KaryawanRoster;
use App\Models\Pengingat;
use App\Models\PeriodeRoster;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
                $datas = PeriodeRoster::with('karyawanRoster')->where([
                    'awal_periode' => $request->awal_periode,
                    'akhir_periode' => $request->akhir_periode,
                ])->get();

                foreach ($datas as $data) {
                    $periode = [
                        'id' => $data->id,
                        'awal_periode' => $data->awal_periode,
                        'akhir_periode' => $data->akhir_periode,
                    ];
                    $rosters = $data->karyawanRoster;
                }
                $url = prev_segments(url()->current());
                return view('karyawan_roster.index', compact('periode', 'rosters', 'list_periode'));
            }
        }

        $list_periode = PeriodeRoster::orderBy('id', 'DESC')->get();
        $datas = PeriodeRoster::with('karyawanRoster')->where([
            'awal_periode' => date('Y', strtotime("-1 year")),
            'akhir_periode' => date('Y', strtotime(Carbon::now()))
        ])->get();

        foreach ($datas as $data) {
            $periode = [
                'id' => $data->id,
                'awal_periode' => $data->awal_periode,
                'akhir_periode' => $data->akhir_periode,
            ];
            $rosters = $data->karyawanRoster;
        }

        return view('karyawan_roster.index', compact('periode', 'rosters', 'list_periode'));
    }

    public function importKaryawanRoster(Request $request)
    {
        Excel::import(new KaryawanRosterImport, $request->file('file'));
        return back()->with('success', 'Data Karyawan Roster Berhasil ditambahkan');
    }

    public function pengingat(Request $request)
    {
        try {
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
                    'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti roster minggu pertama periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode,
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
                    'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti roster minggu kedua periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode,
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
                    'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti roster minggu ketiga periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode,
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
                    'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti roster minggu keempat periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode,
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
                    'pesan' => 'Karyawan an: ' . getName($row->nik_karyawan) . ' dengan NIK :' . $row->nik_karyawan . ' telah mendekati masa cuti roster minggu kelima periode ' . $data_periode->awal_periode . '-' . $data_periode->akhir_periode,
                    'periode_id' => $row->periode_id,
                    'periode_mingguan' => '5',
                    'tanggal_cuti' => $row->minggu_kelima,
                    'flg_kirim' => 0
                ];
            }
            $batch_pengingat = array_merge($minggu_pertama, $minggu_kedua, $minggu_ketiga, $minggu_keempat, $minggu_kelima);
            foreach (array_chunk($batch_pengingat, 300) as $chunk) {
                Pengingat::insert($chunk);
            }
            return redirect('roster')->with('success', 'Pengingat untuk periode ' . $data_periode->awal_periode . ' - ' . $data_periode->akhir_periode);
        } catch (\Throwable $e) {
            return back()->with('error', 'Upps, Terjadi kesalahan');
        }
    }

    public function reminder()
    {
        $datas = Pengingat::with('periode')->where('tanggal_cuti', '>=', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateString())))->where('flg_kirim', '1')->orderBy('tanggal_cuti', 'ASC')->get();
        return view('pengingat.index', compact('datas'))->with('no');
    }
}
