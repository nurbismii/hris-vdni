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
        
        $employee = employee::where('nik', $request->nik)->first();
        $pasal = Pasal::all();
        return view('industrial_relations.severance-pay.create', compact('employee', 'pasal'));
    }
}
