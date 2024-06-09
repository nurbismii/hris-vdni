<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Lembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class LemburController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin-dept.lembur.index');
    }

    public function serverSideLembur(Request $request)
    {
        $data = Lembur::leftJoin('employees', 'employees.nik', '=', 'lembur.nik_karyawan')
            ->where('employees.divisi_id', Auth::user()->employee->divisi_id)
            ->orderBy('lembur.created_at', 'desc')
            ->select(
                'lembur.*',
                'employees.nama_karyawan',
                DB::raw('TIMESTAMPDIFF(HOUR, STR_TO_DATE(lembur.mulai_lembur, "%H:%i"), STR_TO_DATE(lembur.berakhir_lembur, "%H:%i")) as selisih_lembur')
            );

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('admin-dept.lembur._action', [
                    'data' => $data,
                    'url_show' => route('show.lembur', $data->id)
                ]);
            })->filter(function ($instance) use ($request) {
                if ($request->tipe_lembur == '1' || $request->tipe_lembur == '2' || $request->tipe_lembur == '3') {
                    $instance->where('tipe_lembur', $request->get('tipe_lembur'));
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('nik_karyawan', 'LIKE', "%$search%")
                            ->orWhere('nama_karyawan', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin-dept.lembur.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Lembur::create([
            'nik_karyawan' => $request->nik_karyawan,
            'dept_id' => $request->dept_id,
            'div_id' => $request->div_id,
            'tanggal_pengajuan' => $request->tanggal_pengajuan,
            'posisi' => $request->posisi,
            'mulai_lembur' => $request->mulai_lembur,
            'berakhir_lembur' => $request->berakhir_lembur,
            'keterangan' => $request->keterangan,
            'tipe_lembur' => $request->tipe_lembur,
            'persetujuan_hod' => 'Menunggu',
            'persetujuan_karyawan' => 'Menunggu',
        ]);

        return back()->with('success', 'Berhasil melakukan pengajuan SPL');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Lembur::with('karyawan')
            ->leftJoin('employees', 'employees.nik', '=', 'lembur.nik_karyawan')
            ->where('employees.divisi_id', Auth::user()->employee->divisi_id)
            ->where('lembur.id', $id)
            ->orderBy('lembur.created_at', 'desc')
            ->select(
                'lembur.*',
                'employees.nama_karyawan',
                'employees.no_telp',
                'employees.divisi_id',
                DB::raw('TIMESTAMPDIFF(HOUR, STR_TO_DATE(lembur.mulai_lembur, "%H:%i"), STR_TO_DATE(lembur.berakhir_lembur, "%H:%i")) as selisih_lembur')
            )->first();

        return view('admin-dept.lembur.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Lembur::where('id', $id)->update([
            'persetujuan_hod' => $request->persetujuan_hod
        ]);
        return back()->with('success', 'Berhasil memperbarui status pengajuan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function karyawanLembur()
    {
        $data =  Lembur::with('karyawan')
            ->leftJoin('employees', 'employees.nik', '=', 'lembur.nik_karyawan')
            ->where('lembur.nik_karyawan', Auth::user()->nik_karyawan)
            ->orderBy('lembur.created_at', 'desc')
            ->select(
                'lembur.*',
                'employees.nama_karyawan',
                'employees.no_telp',
                'employees.divisi_id',
                DB::raw('TIMESTAMPDIFF(HOUR, STR_TO_DATE(lembur.mulai_lembur, "%H:%i"), STR_TO_DATE(lembur.berakhir_lembur, "%H:%i")) as selisih_lembur')
            )->get();


        return view('account.lembur.index', compact('data'));
    }

    public function karyawanLemburShow($id)
    {
        $data = Lembur::with('karyawan')
            ->leftJoin('employees', 'employees.nik', '=', 'lembur.nik_karyawan')
            ->where('employees.divisi_id', Auth::user()->employee->divisi_id)
            ->where('lembur.id', $id)
            ->orderBy('lembur.created_at', 'desc')
            ->select(
                'lembur.*',
                'employees.nama_karyawan',
                'employees.no_telp',
                'employees.divisi_id',
                DB::raw('TIMESTAMPDIFF(HOUR, STR_TO_DATE(lembur.mulai_lembur, "%H:%i"), STR_TO_DATE(lembur.berakhir_lembur, "%H:%i")) as selisih_lembur')
            )->first();

        return view('account.lembur.show', compact('data'));
    }

    public function karyawanLemburUpdate(Request $request, $id)
    {
        //
        Lembur::where('id', $id)->update([
            'persetujuan_karyawan' => $request->persetujuan_karyawan
        ]);
        return back()->with('success', 'Kamu menyetujui permintaan lembur');
    }

    public function lembur()
    {
        $dept = Departemen::all();

        return view('lembur.index', compact('dept'));
    }

    public function serverSideLemburAll(Request $request)
    {
        $data = Lembur::leftJoin('employees', 'employees.nik', '=', 'lembur.nik_karyawan')
            ->leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
            ->leftjoin('departemens', 'departemens.id', '=', 'divisis.departemen_id')
            ->orderBy('lembur.created_at', 'desc')
            ->select(
                'lembur.*',
                'employees.nama_karyawan',
                DB::raw('TIMESTAMPDIFF(HOUR, STR_TO_DATE(lembur.mulai_lembur, "%H:%i"), STR_TO_DATE(lembur.berakhir_lembur, "%H:%i")) as selisih_lembur')
            );

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('lembur._action', [
                    'data' => $data,
                    'url_show' => route('lembur.show.hr', $data->id)
                ]);
            })->filter(function ($instance) use ($request) {
                if ($request->tipe_lembur == '1' || $request->tipe_lembur == '2' || $request->tipe_lembur == '3') {
                    $instance->where('tipe_lembur', $request->get('tipe_lembur'));
                }
                if ($request->departemen != '') {
                    $instance->where('dept_id', $request->get('departemen'));
                }
                if ($request->divisi != '') {
                    $instance->where('div_id', $request->get('divisi'));
                }
                if ($request->get('periode_pengajuan') != '') {
                    $periode = $request->periode_pengajuan;
                    $periode = $periode . '-16';
                    $minus_one_month = date('Y-m-d', strtotime("$periode -1 Month"));
                    $plus_one_month_minus_one_day = date('Y-m-d', strtotime("$minus_one_month +1 Month -1 Day"));
                    $instance->whereBetween('tanggal_pengajuan', [$minus_one_month, $plus_one_month_minus_one_day]);
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('nik_karyawan', 'LIKE', "%$search%")
                            ->orWhere('nama_karyawan', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function lemburShow($id)
    {
        $data = Lembur::with('karyawan')
            ->leftJoin('employees', 'employees.nik', '=', 'lembur.nik_karyawan')
            ->where('lembur.id', $id)
            ->orderBy('lembur.created_at', 'desc')
            ->select(
                'lembur.*',
                'employees.nama_karyawan',
                'employees.no_telp',
                'employees.divisi_id',
                DB::raw('TIMESTAMPDIFF(HOUR, STR_TO_DATE(lembur.mulai_lembur, "%H:%i"), STR_TO_DATE(lembur.berakhir_lembur, "%H:%i")) as selisih_lembur')
            )->first();

        return view('lembur.show', compact('data'));
    }
}
