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

class EmployeeController extends Controller
{
    protected $default;

    public function __construct($default = 100)
    {
        $this->default = $default;
    }

    public function index()
    {
        $datas = employee::orderBy('nik', 'DESC')->limit($this->default)->get();
        return view('employee.index', compact('datas'));
    }

    public function filter(Request $request)
    {
        $datas = employee::select('*');
        if (count($datas->get()) > 0) {
            if ($request->nik != '' && $request->nik) {
                $filter = $datas->where('nik', 'like', '%' . $request->nik . '%')->get();
                return view('employee.index', ['datas' => $filter]);
            }
        }
        if (count($datas->get()) > 0) {
            if (($request->entry_date_start !=  '')  && ($request->entry_date_end != '')) {
                $start_date = $request->entry_date_start;
                $end_date = $request->entry_date_end;

                $filter = employee::whereBetween('entry_date', [$start_date, $end_date])->get();
                return view('employee.index', ['datas' => $filter]);
            }
        }
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

    public function show($id)
    {
        try {
            $data = employee::where('nik', $id)->first();
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
        try {
            $data = employee::where('nik', $id)->first();
            $data->update($request->all());
            return back()->with('error', 'Employee has been updated');
        } catch (\Throwable $e) {
            return redirect('employees', 'Something wrong');
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
        return Excel::download(new EmployeeExport, 'EmployeeExample.xlsx');
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
