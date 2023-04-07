<?php

namespace App\Http\Controllers;

use App\Exports\ContractExport;
use App\Imports\ContractDestroyImport;
use App\Imports\ContractImport;
use App\Imports\ContractUpdateImport;
use App\Models\Contract;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ContractController extends Controller
{

    public function index()
    {
        return view('contract.index');
    }

    public function show($no_pwkt)
    {
        $data = Contract::where('no_pkwt', $no_pwkt)->first();
        return view('contract.show', compact($data));
    }

    public function serverSide()
    {
        $contract = Contract::query();
        return DataTables::of($contract)
            ->addColumn('action', function ($contract) {
                $btn = '<a href="/contract/show/' . $contract->no_pkwt . '" data-toggle="tooltip"  data-id="' . $contract->no_pkwt . '" data-original-title="Show" class="contract btn btn-outline-purple btn-sm showContract">Show</a>';
                return $btn;
            })
            ->rawColumns([
                'action',
            ])->make(true);
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
