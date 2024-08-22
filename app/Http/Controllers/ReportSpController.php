<?php

namespace App\Http\Controllers;

use App\Imports\SpreportImport;
use App\Imports\SpreportImportDestroy;
use App\Imports\SpreportImportUpdate;
use App\Models\SpReport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Datatables;

class ReportSpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('industrial_relations.report-sp.index');
    }

    public function serverSidePeringatan(Request $request)
    {
        $data = SpReport::join('employees', 'employees.nik', '=', 'sp_report.nik_karyawan')->select('*', 'employees.nama_karyawan');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('industrial_relations.report-sp._action', [
                    'data' => $data,
                    'url_detail' => route('employee.edit', $data->nik),
                ]);
            })->filter(function ($instance) use ($request) {

                if ($request->get('level_sp') != '') {
                    $instance->where('level_sp', $request->get('level_sp'));
                }

                if ($request->get('periode_sp') != '') {
                    $periode = $request->periode_sp;
                    $periode = $periode . '-16';

                    $minus_one_month = date('Y-m-d', strtotime("$periode -1 Month"));
                    $plus_one_month_minus_one_day = date('Y-m-d', strtotime("$minus_one_month +1 Month -1 Day"));

                    $instance->whereBetween('tgl_mulai', [$minus_one_month, $plus_one_month_minus_one_day]);
                }

                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->where('level_sp', 'LIKE', "%$search%");
                        $w->Orwhere('nik', 'LIKE', "%$search%");
                    });
                }
            })->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = SpReport::with('employee')->findorFail($id);
        return view('industrial_relations.report-sp.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Import file sp report
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function importView(Request $request)
    {
        return view('industrial_relations.report-sp.import');
    }

    /**
     * Import file sp report
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function importStore(Request $request)
    {
        try {
            Excel::import(new SpreportImport, $request->file('file'));
            return back()->with('success', 'Import was successful');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $row = $failure->row(); // row that went wrong
                $attribute = $failure->attribute(); // either heading key (if using heading row concern) or column index
                $errors = $failure->errors(); // Actual error messages from Laravel validator
                $values = $failure->values(); // The values of the row that has failed.
            }

            return back()->with('error', 'There were validation errors during the import.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred during the import: ' . $e->getMessage());
        }
    }

    /**
     * Import file sp report
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function importUpdate(Request $request)
    {
        Excel::import(new SpreportImportUpdate, $request->file('file'));
        return back()->with('success', 'Import update successful');
    }

    /**
     * Import file sp report
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function importDestroy(Request $request)
    {
        Excel::import(new SpreportImportDestroy, $request->file('file'));
        return back()->with('success', 'Import delete successful');
    }
}
