<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartemenRequest;
use App\Models\Departemen;
use App\Models\Divisi;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Departemen::all();
        return view('departemen.index', compact('data'))->with('no');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartemenRequest $request)
    {
        try {
            Departemen::create([
                'perusahaan_id' => $request->perusahaan_id,
                'departemen' => $request->departemen,
                'kepala_dept' => $request->kepala_dept,
                'no_telp_departemen' => $request->no_telp_departemen,
                'status_pengeluaran' => $request->status_pengeluaran,
            ]);
            return back()->with('success', 'Departemen berhasil ditambahkan');
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan pada permintaan');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Departemen::where('id', $id)->update([
            'perusahaan_id' => $request->perusahaan_id,
            'departemen' => $request->departemen,
            'kepala_dept' => $request->kepala_dept,
            'no_telp_departemen' => $request->no_telp_departemen,
            'status_pengeluaran' => $request->status_pengeluaran,
        ]);
        return back()->with('success', 'Departemen berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departemen  $departemen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = Departemen::where('id', $id)->first();
        Divisi::where('departemen_id', $data->id)->delete();
        $data->delete();
        return back()->with('success', 'Departemen berhasil dihapus');
    }

    public function divisi($id)
    {
        $data = Departemen::where('id', $id)->first();
        $divisi = Divisi::where('departemen_id', $data->id)->get();
        return view('divisi.index', compact('data', 'divisi'))->with('no');
    }
}
