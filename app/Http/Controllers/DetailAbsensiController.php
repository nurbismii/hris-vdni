<?php

namespace App\Http\Controllers;

use App\Imports\ImportDetailAbsensi;
use App\Models\DetailAbsensi;
use App\Models\Divisi;
use App\Models\employee;
use App\Models\KeteranganAbsensi;
use App\Models\PeriodeBulan;
use App\Models\PeriodeTahun;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class DetailAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = PeriodeTahun::all();
        foreach ($datas as $data) {
            $tahun[] = [
                'id' => $data->id,
                'tahun' => $data->tahun
            ];
        }
        $data_bulan = PeriodeBulan::all();
        return view('customize_setting.periode_absen.index', compact('tahun', 'datas', 'data_bulan'))->with('no');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $tahun = PeriodeTahun::create([
                'tahun' => $request->tahun,
            ]);

            $bulan = $request['bulan'];

            for ($i = 0; $i < count($bulan); $i++) {
                $datas[] = [
                    'periode_tahun_id' => $tahun->id,
                    'nama_bulan' => $bulan[$i],
                ];
            }
            PeriodeBulan::insert($datas);
            DB::commit();
            return back()->with('success', 'Periode tahun dan bulan berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan!');
        }
    }

    public function getDetailAbsensi(Request $request)
    {
        $datas = PeriodeTahun::orderBy('tahun', 'DESC')->get();
        $data_absen = [];
        $bulan = [];
        if ($request->tahun_id && $request->bulan_id) {
            $tahun = PeriodeTahun::where('id', $request->tahun_id)->first();
            $bulan = PeriodeBulan::where('id', $request->bulan_id)->where('periode_tahun_id', $tahun->id)->first();
            $data_absen = DetailAbsensi::where('periode_bulan_id', $bulan->id)->get();
        }
        return view('kehadiran.detail', compact('datas', 'data_absen', 'bulan'));
    }

    public function getDetailAbsensiByNik($nik_karyawan, $bulan_id)
    {
        $karyawan = employee::where('nik', $nik_karyawan)->first();
        $bulan = PeriodeBulan::with('periode_tahun')->where('id', $bulan_id)->first();
        $divisi = Divisi::with('departemen')->where('id', $karyawan->divisi_id)->first();
        $detail_absen = DetailAbsensi::where('nik_karyawan', $nik_karyawan)->where('periode_bulan_id', $bulan_id)->first();
        $keterangan_absen = KeteranganAbsensi::where('nik_karyawan', $nik_karyawan)->where('periode_bulan_id', $bulan_id)->get();
        return view('kehadiran.show', compact('divisi', 'detail_absen', 'karyawan', 'bulan', 'keterangan_absen'));
    }

    public function dropwdownBulan($id)
    {
        $bulan = PeriodeBulan::where('periode_tahun_id', $id)->get();
        return response()->json($bulan);
    }

    public function importAbsensi(Request $request)
    {
        Excel::import(new ImportDetailAbsensi, $request->file('file'));
        return back()->with('success', 'Data Karyawan Berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DetailAbsensi  $detailAbsensi
     * @return \Illuminate\Http\Response
     */
    public function destroy(DetailAbsensi $detailAbsensi)
    {
        //
    }
}
