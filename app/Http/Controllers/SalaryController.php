<?php

namespace App\Http\Controllers;

use App\Exports\ExportSalaries;
use App\Imports\ImportSalaries;
use App\Models\fileSalary;
use App\Models\salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class SalaryController extends Controller
{
    public function index()
    {
        return view('payslip.index');
    }

    public function slipgaji(Request $request)
    {
        $periode = date('Y-m', strtotime($request->periode));
        $datas = salary::where('akhir_periode', 'like', '%' . $periode . '%')->get();
        return view('payslip.slipgaji', compact('datas'));
    }

    public function show($id)
    {
        $data = salary::findOrFail($id);
        $total_deduction = $data->jht + $data->jp + $data->bpjs_kesehatan + $data->deduction_unpaid_leave + $data->deduction_php21;
        $total_diterima = ($data->gaji_pokok + $data->tunjangan_umum + $data->tunjangan_pengawas + $data->tunjangan_transport + $data->tunjangan_mk + $data->tunjangan_koefisien + $data->rapel + $data->insentif + $data->tunjangan_lap);
        $gaji_bersih = ($total_diterima - $total_deduction);

        return view('payslip.show', compact('data', 'total_diterima', 'total_deduction', 'gaji_bersih'));
    }

    public function history()
    {
        $datas = fileSalary::orderBy('id', 'DESC')->limit(100)->get();
        return view('payslip.history', compact('datas'))->with('no');
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

    public function exportSalary(Request $request)
    {
        return Excel::download(new ExportSalaries, 'Salary-Template.xlsx');
    }
}
