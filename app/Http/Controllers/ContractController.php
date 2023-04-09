<?php

namespace App\Http\Controllers;

use App\Exports\ContractExport;
use App\Imports\ContractDestroyImport;
use App\Imports\ContractImport;
use App\Imports\ContractUpdateImport;
use App\Models\Contract;
use App\Models\employee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ContractController extends Controller
{

    public function index()
    {
        return view('contract.index');
    }

    public function show($nik)
    {
        $contract  = Contract::where('nik', $nik)->first();
        return view('contract.show', compact('contract'));
    }

    public function serverSide()
    {
        $contract = Contract::where('nik', '!=', 0)->get();
        return DataTables::of($contract)
            ->addColumn('action', function ($contract) {
                return view('contract._action', [
                    'contract' => $contract,
                    'url_show' => route('contract.show', $contract->nik)
                ]);
            })->addIndexColumn()->rawColumns(['action'])->make(true);
    }

    public function downloadExample()
    {
        return Excel::download(new ContractExport, 'EmployeeExample.xlsx');
    }

    public function importContract(Request $request)
    {
        Excel::import(new ContractImport, $request->file('file'));
        return back()->with('success', 'All good!');
    }

    public function updateImportContract(Request $request)
    {
        Excel::import(new ContractUpdateImport, $request->file('file'));
        return back()->with('success', 'All good!');
    }

    public function destroyImportContract(Request $request)
    {
        Excel::import(new ContractDestroyImport, $request->file('file'));
        return back()->with('success', 'All good!');
    }
}
