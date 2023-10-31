<?php

namespace App\Http\Controllers;

use App\Models\Pasal;
use App\Models\employee;
use App\Models\Severancepay;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeverancepayController extends Controller
{
    //
    public function index()
    {
        $datas = Severancepay::with('employee')->get();
        return view('industrial_relations.severance-pay.index', compact('datas'));
    }

    public function create(Request $request)
    {
        $pasal = Pasal::all();
        return view('industrial_relations.severance-pay.create', compact('pasal'));
    }

    public function store(Request $request)
    {
        $checked = Severancepay::where('nik_karyawan', $request->nik_karyawan)->first();

        if ($checked) {
            return back()->with('warning', 'The added data has been registered');
        }
        try {
            DB::beginTransaction();
            $request = [
                'nik_karyawan' => $request->nik_karyawan,
                'pasal' => $request->pasal,
                'pelanggaran' => $request->pelanggaran,
                'bil_severance' => $request->bil_severance,
                'remaining_leave' => $request->remaining_leave,
                'net_salary' => $request->net_salary,
                'subtotal_severance' => $request->subtotal_severance,
                'basic_salary' => $request->basic_salary,
                'bil_award' => $request->service_year_award,
                'service_year' => $request->service_year,
                'subtotal_award' => $request->subtotal_award,
                'bil_annual' => $request->bil_annual,
                'subtotal_annual' => $request->subtotal_annual,
                'bil_compensation' => $request->bil_compensation,
                'return_cost' => $request->return_cost,
                'total_severance' => $request->total_severance,
                'payroll_period' => $request->payroll_period,
                'termination_date' => $request->termination_date,
            ];
            Severancepay::create($request);
            DB::commit();
            return back()->with('success', 'Data added successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to add data');
        }
    }

    public function print($id)
    {
        $data = Severancepay::with('spreport')->where('id', $id)->first();
        if ($data->pasal == '52 ayat (2)') {
            $pdf = PDF::loadView('industrial_relations.severance-pay.severance-print-522', compact('data'))->setPaper('a4');
        }
        if ($data->pasal == '52 ayat (1)') {
            $pdf = PDF::loadView('industrial_relations.severance-pay.severance-print-521', compact('data'))->setPaper('a4');
        }
        if ($data->pasal == '51') {
            $pdf = PDF::loadView('industrial_relations.severance-pay.severance-print-51', compact('data'))->setPaper('a4');
        }
        if ($data->pasal == '16') {
            $pdf = PDF::loadView('industrial_relations.severance-pay.severance-print-16', compact('data'))->setPaper('a4');
        }
        return $pdf->stream();
    }
}
