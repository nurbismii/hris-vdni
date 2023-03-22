<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Http\Requests\StoreEmployeeRequest;
use App\Imports\EmployeesImport;
use App\Models\employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.index');
    }

    public function create()
    {
        return view('employee.create');
    }

    public function store(StoreEmployeeRequest $request)
    {
        employee::create($request->all());
        return back()->with('success', 'Succesfully added employee');
    }

    public function show(employee $employee)
    {
        //
    }

    public function edit(employee $employee)
    {
        //
    }

    public function update(Request $request, employee $employee)
    {
        //
    }

    public function destroy(employee $employee)
    {
        //
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
        // if ($request->hasFile('file')) {
        //     $file = $request->file('file');
        //     $file_name = $file->getClientOriginalName();
        //     $file->move('import/employee', $file_name);
        //     $import = new EmployeesImport;
        //     Excel::import($import, public_path('import/employee/' . $file_name));
        //     return back()->with('success', 'All good!');
        // }
    }
}
