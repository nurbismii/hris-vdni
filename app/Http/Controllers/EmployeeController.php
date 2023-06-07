<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Http\Requests\StoreEmployeeRequest;
use App\Imports\EmployeesDeleteImport;
use App\Imports\EmployeesImport;
use App\Imports\EmployeesUpdateImport;
use App\Models\employee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    protected $default;

    public function __construct($default = 10000)
    {
        $this->default = $default;
    }

    public function index()
    {
        return view('employee.index');
    }

    public function serverSideEmployee()
    {
        $data = employee::query();
        return DataTables::of($data)->addColumn('action', function ($data) {
            return view('employee._action', [
                'data' => $data,
                'url_show' => route('employee.show', $data->nik),
            ]);
        })->addIndexColumn()->rawColumns(['action'])->make(true);
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(StoreEmployeeRequest $request)
    {
        employee::create($request->all());
        return back()->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function show($nik)
    {
        try {
            $data = employee::where('nik', $nik)->first();
            $level_vaksin = $data->vaksin == '0' ? 'Belum Vaksin' : ($data->vaksin == '1' ? 'Vaksin 1' : ($data->vaksin == '2' ? 'Vaksin 2' : ($data->vaksin == '3' ? 'Booster 1' : ($data->vaksin == '4' ? 'Booster 2' : 'Tidak diketahui'))));
            return view('employee.show', compact('data', 'level_vaksin'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            employee::where('nik', $id)->update([
                'no_sk_pkwtt' => $request['no_sk_pkwtt'],
                'nama_karyawan' => $request['nama_karyawan'],
                'nama_ibu_kandung' => $request['nama_ibu_kandung'],
                'agama' => $request['agama'],
                'no_ktp' => $request['no_ktp'],
                'no_kk' => $request['no_kk'],
                'jenis_kelamin' => $request['jenis_kelamin'],
                'status_perkawinan' => $request['status_perkawinan'],
                'status_karyawan' => $request['status_karyawan'],
                'tgl_resign' => $request->tgl_resign ?? null,
                'no_telp' => $request['no_telp'],
                'tgl_lahir' => $request->tgl_lahir ?? null,
                'area_kerja' => $request['area_kerja'],
                'golongan_darah' => $request['golongan_darah'],
                'entry_date' => $request->entry_date ?? null,
                'npwp' => $request['npwp'],
                'bpjs_kesehatan' => $request['bpjs_kesehatan'],
                'bpjs_tk' => $request['bpjs_tk'],
                'vaksin' => $request['vaksin'],
                'jam_kerja' => $request['jam_kerja'],
                'status_resign' => $request['status_resign'],
                'posisi' => $request['posisi'],
                'jabatan' => $request['jabatan'],
            ]);
            return redirect('employees')->with('success', 'Data karyawan berhasil diperbarui');
        } catch (\Throwable $e) {
            return redirect('employees')->with('error', 'Terjadi kesalahan!');
        }
    }

    public function destroy($id)
    {
        try {
            employee::where('nik', $id)->delete();
            return back()->with('success', 'Karyawan berhasil dihapus');
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function import()
    {
        return view('employee.import');
    }

    public function downloadExample()
    {
        return Excel::download(new EmployeeExport, 'Template Karyawan.xlsx');
    }

    public function importEmployee(Request $request)
    {
        Excel::import(new EmployeesImport, $request->file('file'));
        return back()->with('success', 'Data Karyawan Berhasil ditambahkan');
    }

    public function updateImportEmployee(Request $request)
    {
        Excel::import(new EmployeesUpdateImport, $request->file('file'));
        return back()->with('success', 'Data Karyawan Berhasil diperbarui');
    }

    public function destroyImportEmployee(Request $request)
    {
        Excel::import(new EmployeesDeleteImport, $request->file('file'));
        return back()->with('success', 'Data Karyawan Berhasil dihapus');
    }
}
