<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Models\employee;
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

    public function store(Request $request)
    {
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
}
