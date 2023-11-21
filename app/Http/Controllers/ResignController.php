<?php

namespace App\Http\Controllers;

use App\Imports\ResignImport;
use App\Imports\ResignImportUpdate;
use App\Models\Resign;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ResignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('industrial_relations.resign.index');
    }

    public function serverSideResign(Request $request)
    {
        $data = Resign::join('employees', 'employees.nik', '=', 'resign.nik_karyawan')
            ->select(DB::raw("*"));
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('industrial_relations.resign._action', [
                    'data' => $data,
                    'url_edit' => route('resign.edit', $data->nik_karyawan),
                    'url_surat' => route('resign.surat', $data->nik_karyawan),
                ]);
            })->filter(function ($instance) use ($request) {
                if ($request->tipe == 'BAIK' || $request->tipe == 'PASAL (50)' || $request->tipe == 'PB RESIGN' || $request->tipe == 'PHK' || $request->tipe == 'KABUR' || $request->tipe == 'PUTUS KONTRAK') {
                    $instance->where('tipe', $request->get('tipe'));
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Resign::join('employees', 'employees.nik', '=', 'resign.nik_karyawan')
            ->leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
            ->leftjoin('departemens', 'departemens.id', '=', 'divisis.departemen_id')
            ->where('resign.nik_karyawan', $id)
            ->select(DB::raw('*'))->first();

        if ($data->tipe == 'PUTUS KONTRAK') {
            return back()->with('info', 'Surat keterangan tidak perpanjang kontrak kerja tidak tersedia, cek tipe permintaan terlebih dahulu');
        }

        return view('industrial_relations.resign.edit', compact('data'));
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

    public function importView()
    {
        return view('industrial_relations.resign.import');
    }

    public function importStore(Request $request)
    {
        Excel::import(new ResignImport, $request->file('file'));
        return back()->with('success', 'Import data resign berhasil');
    }

    public function importUpdate(Request $request)
    {
        Excel::import(new ResignImportUpdate, $request->file('file'));
        return back()->with('success', 'Import data resign berhasil diperbarui');
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

        $pdf = PDF::loadView('industrial_relations.resign.surat', compact('data'))->setPaper('a4');
        return $pdf->stream();
    }
}