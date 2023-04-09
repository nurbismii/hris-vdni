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
        return back()->with('success', 'Employee has been added');
    }

    public function show($nik)
    {
        try {
            $data = employee::where('nik', $nik)->first();
            return view('employee.show', compact('data'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function edit($id)
    {
        try {
            $data = employee::where('nik', $id)->first();
            return view('employee.edit' . compact('data'));
        } catch (\Throwable  $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function update(Request $request, $id)
    {
        $data = employee::where('nik', $id)->first();
        $data->update([
            'nik' => $request->nik,
            'no_ktp' => $request->no_ktp,
            'name' => $request->name,
            'date_of_birth' => $request->date_of_birth,
            'company_name' => $request->company_name,
            'npwp' => $request->npwp,
            'bpjs_ket' => $request->bpjs_ket,
            'bpjs_tk' => $request->bpjs_tk,
            'vaccine' => $request->vaccine,
            'entry_date' => date('Y-m-d', strtotime($request->entry_date)),
        ]);
        return back()->with('success', 'Employee has been updated');
        try {
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function destroy($id)
    {
        try {
            employee::where('nik', $id)->delete();
            return back()->with('success', 'Employee has been deleted');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function import()
    {
        return view('employee.import');
    }

    public function downloadExample()
    {
        return Excel::download(new EmployeeExport, 'Employee-Template.xlsx');
    }

    public function importEmployee(Request $request)
    {
        Excel::import(new EmployeesImport, $request->file('file'));
        return back()->with('success', 'All good!');
    }

    public function updateImportEmployee(Request $request)
    {
        Excel::import(new EmployeesUpdateImport, $request->file('file'));
        return back()->with('success', 'All good!');
    }

    public function destroyImportEmployee(Request $request)
    {
        Excel::import(new EmployeesDeleteImport, $request->file('file'));
        return back()->with('success', 'All good!');
    }
}
