<?php

namespace App\Http\Controllers;

use App\Models\Pasal;
use App\Models\employee;
use App\Models\Severancepay;
use Illuminate\Http\Request;

class SeverancepayController extends Controller
{
    //
    public function index()
    {
        $datas = Severancepay::all();
        return view('industrial_relations.severance-pay.index', compact('datas'));
    }

    public function create(Request $request)
    {
        $pasal = Pasal::all();
        return view('industrial_relations.severance-pay.create', compact('pasal'));
    }

    public function store(Request $request)
    {
        $request = [
            'nik_karyawan' => $request->nik_karyawan,
            'pasal' => $request->pasal,
            'pelanggaran' => $request->pelanggaran,
            'bil_severance' => $request->bil_severance,
            'remaining_leave' => $request->remaining_leave,
            'net_salary' => $request->net_salary,
            'subtotal_severance' => $request->subtotal_severance,
            'basis_salary' => $request->basic_salary,
            'bil_award' => $request->bil_award,
            'service_year' => $request->service_year,
            'subtotal_award' => $request->subtotal_award,
            'bil_annual' => $request->bil_annual,
            'subtotal_annual' => $request->subtotal_annual,
            'bil_compensation' => $request->bil_compensation,
            'return_cost' => $request->return_cost,
            'total_severance' => $request->total_severance,
            'termination_date' => $request->termination_date,
        ];
        
        return $request;
    }
}
