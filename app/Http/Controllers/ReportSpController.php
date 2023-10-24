<?php

namespace App\Http\Controllers;

use App\Imports\SpreportImport;
use App\Imports\SpreportImportDestroy;
use App\Imports\SpreportImportUpdate;
use App\Models\SpReport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportSpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $datas = SpReport::all();
        return view('industrial_relations.report-sp.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        Excel::import(new SpreportImport, $request->file('file'));
        return back()->with('success', 'Import was successful');
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
