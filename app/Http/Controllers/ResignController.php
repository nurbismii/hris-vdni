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
        $validTipe = [
            'RESIGN SESUAI PROSEDUR',
            'RESIGN TIDAK SESUAI PROSEDUR',
            'PB RESIGN',
            'PHK',
            'PB PHK',
            'PHK MENINGGAL DUNIA',
            'PHK PENSIUN',
            'PUTUS KONTRAK'
        ];

        $tipe = $request->tipe;
        $search = $request->get('search');
        $periode = $request->get('periode_resign');

        // Query dasar
        $query = Resign::with('employee')
            ->select('nik_karyawan', 'tanggal_keluar', 'tipe');

        // Filter tipe jika valid
        if (in_array($tipe, $validTipe)) {
            $query->where('tipe', $tipe);
        }

        // Filter search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nik_karyawan', 'LIKE', "%{$search}%")
                    ->orWhereHas('employee', function ($q2) use ($search) {
                        $q2->where('nama_karyawan', 'LIKE', "%{$search}%");
                    });
            });
        }

        // Filter periode resign
        if (!empty($periode)) {
            try {
                $periodeDate = \Carbon\Carbon::createFromFormat('Y-m', $periode)->startOfMonth()->addDays(15);
                $start = $periodeDate->copy()->subMonth()->startOfMonth();
                $end = $start->copy()->endOfMonth();

                $query->whereBetween('tanggal_keluar', [$start->toDateString(), $end->toDateString()]);
            } catch (\Exception $e) {
                // Invalid format, ignore filter
            }
        }

        // Datatables handle
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('industrial_relations.resign._action', [
                    'data' => $data,
                    'url_edit' => route('resign.edit', $data->nik_karyawan),
                    'url_surat' => route('resign.surat', $data->nik_karyawan),
                ]);
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
