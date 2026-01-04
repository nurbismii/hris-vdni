<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Divisi;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Perusahaan::all();
        return view('admin.perusahaan.index', compact('data'))->with('no');
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
        Perusahaan::create([
            'kode_perusahaan' => $request->kode_perusahaan,
            'nama_perusahaan' => $request->nama_perusahaan
        ]);

        return back()->with('success', 'Perusahaan berhasil ditambahkan');
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
        $data_pt = Perusahaan::where('id', $id)->first();
        $data = Departemen::where('perusahaan_id', $id)->get();
        return view('admin.departemen.index', compact('data', 'data_pt'))->with('no');
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
        Perusahaan::where('id', $id)->update([
            'kode_perusahaan' => $request->kode_perusahaan,
            'nama_perusahaan' => $request->nama_perusahaan
        ]);

        return back()->with('success', 'Perusahaan berhasil diperbarui');
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
        $data = Perusahaan::where('id', $id)->first();
        $dept = Departemen::where('perusahaan_id', $data->id)->first();
        Divisi::where('departemen_id', $dept->id)->delete();
        Departemen::where('perusahaan_id', $data->id)->delete();

        return back()->with('success', 'Perusahaan berhasil dihapus');
    }
}
