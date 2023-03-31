<?php

namespace App\Http\Controllers;

use App\Imports\ImportSalaries;
use App\Models\fileSalary;
use App\Models\salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SalaryController extends Controller
{
    public function index()
    {
        return view('payslip.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function history()
    {
        $datas = fileSalary::orderBy('id', 'DESC')->limit(100)->get();
        return view('payslip.history', compact('datas'))->with('no');
    }

    public function edit(salary $salary)
    {
        //
    }

    public function update(Request $request, salary $salary)
    {
        //
    }

    public function destroy(salary $salary)
    {
        //
    }

    public function importSalary(Request $request)
    {
        if ($request->hasFile('file')) {
            $current_time = date('Y-m-d', strtotime(Carbon::now()));
            $file = $request->file('file');
            $file_name = 'KOMPONEN GAJI (' . $current_time . ')' . '.' . $file->getClientOriginalExtension();
            $file->move('salaries', $file_name);
            $path = 'public/salaries/' . $file_name;

            DB::beginTransaction();
            fileSalary::create([
                'user_id' => Auth::user()->employee_id,
                'path' => $path
            ]);
            Excel::import(new ImportSalaries, public_path('/salaries/' . $file_name));
            DB::commit();
            return back()->with('success', 'Salaries has been uploaded');
        }
    }
}
