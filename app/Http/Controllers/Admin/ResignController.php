<?php

namespace App\Http\Controllers\Admin;

use App\Imports\ResignImport;
use App\Imports\ResignImportUpdate;
use App\Models\Resign;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ResignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.industrial_relations.resign.index');
    }

    public function serverSideResign(Request $request)
    {
        $query = Resign::select('*');

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('admin.industrial_relations.resign._action', [
                    'data' => $data,
                    'url_edit' => route('resign.show', $data->nik_karyawan),
                    'url_surat' => route('resign.surat', $data->nik_karyawan),
                ]);
            })
            ->filter(function ($instance) use ($request) {

                if ($request->filled('tipe')) {
                    $instance->where('resign.tipe', $request->tipe);
                }

                // Filter periode resign
                if ($request->filled('periode_resign')) {
                    try {
                        // Contoh input: 2025-11
                        $periode = \Carbon\Carbon::createFromFormat('Y-m', $request->periode_resign);

                        // 16 bulan sebelumnya
                        $start = $periode->copy()
                            ->subMonth()
                            ->day(16)
                            ->startOfDay();

                        // 15 bulan periode
                        $end = $periode->copy()
                            ->day(15)
                            ->endOfDay();

                        $instance->whereBetween('resign.tanggal_keluar', [
                            $start,
                            $end
                        ]);
                    } catch (\Exception $e) {
                        // abaikan jika format salah
                    }
                }

                // Search optimasi
                if ($request->filled('search')) {
                    $search = trim($request->search);

                    $instance->where(function ($q) use ($search) {
                        $q->where('resign.nik_karyawan', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        Excel::import(new ResignImport, $request->file('file'));
        return back()->with('success', 'Import data resign berhasil');
    }

    public function show($id)
    {
        $data = Resign::join('employees', 'employees.nik', '=', 'resign.nik_karyawan')
            ->leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
            ->leftjoin('departemens', 'departemens.id', '=', 'divisis.departemen_id')
            ->where('resign.nik_karyawan', $id)
            ->select(DB::raw('*'))->first();

        if ($data->tipe == 'PUTUS KONTRAK') {
            return back()->with('info', 'Surat keterangan tidak perpanjang kontrak kerja tidak tersedia, cek tipe permintaan terlebih dahulu');
        }

        return view('admin.industrial_relations.resign.show', compact('data'));
    }

    public function update(Request $request)
    {
        try {
            Excel::import(new ResignImportUpdate, $request->file('file'));
            return back()->with('success', 'Import data resign berhasil diperbarui');
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan pada permintaan');
        }
    }

    public function importView()
    {
        return view('admin.industrial_relations.resign.import');
    }

    public function surat($id)
    {
        $data = Resign::join('employees', 'employees.nik', '=', 'resign.nik_karyawan')
            ->leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
            ->leftjoin('departemens', 'departemens.id', '=', 'divisis.departemen_id')
            ->where('resign.nik_karyawan', $id)
            ->select(DB::raw('*'))->first();

        if ($data->tipe != 'PUTUS KONTRAK') {
            return back()->with('info', 'Surat keterangan tidak perpanjang kontrak kerja tidak tersedia, cek tipe permintaan terlebih dahulu');
        }

        $pdf = PDF::loadView('admin.industrial_relations.resign.surat', compact('data'))->setPaper('a4');
        return $pdf->stream();
    }
}
