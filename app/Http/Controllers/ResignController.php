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
        // Build the initial query with join and select
        $data = Resign::with('employee')->select('resign.nik_karyawan', 'resign.tanggal_keluar', 'resign.tipe');
        
        // Use DataTables to handle the data
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('industrial_relations.resign._action', [
                    'data' => $data,
                    'url_edit' => route('resign.edit', $data->nik_karyawan),
                    'url_surat' => route('resign.surat', $data->nik_karyawan),
                ]);
            })
            ->filter(function ($instance) use ($request) {
                // Filter by 'tipe' if it's in the allowed list
                $validTipe = ['RESIGN SESUAI PROSEDUR', 'RESIGN TIDAK SESUAI PROSEDUR', 'PB RESIGN', 'PHK', 'PB PHK', 'PUTUS KONTRAK'];
                if (in_array($request->tipe, $validTipe)) {
                    $instance->where('tipe', $request->tipe);
                }
    
                // Filter by search term if provided
                if ($search = $request->get('search')) {
                    $instance->where(function ($query) use ($search) {
                        $query->orWhere('nik_karyawan', 'LIKE', "%$search%")
                              ->orWhere('nama_karyawan', 'LIKE', "%$search%");
                    });
                }
    
                // Filter by 'periode_resign' if provided
                if ($request->get('periode_resign')) {
                    $periode_resign = $request->get('periode_resign') . '-16';
                    $minus_one_month = date('Y-m-d', strtotime("$periode_resign -1 Month"));
                    $plus_one_month_minus_one_day = date('Y-m-d', strtotime("$minus_one_month +1 Month -1 Day"));
                    
                    $instance->whereBetween('tanggal_keluar', [$minus_one_month, $plus_one_month_minus_one_day]);
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    

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
