<?php

namespace App\Http\Controllers;

use App\Models\Divisi;
use App\Models\LokasiAbsen;
use Illuminate\Http\Request;

class LokasiAbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datas = LokasiAbsen::all();
        $divisi = Divisi::all();

        return view('customize_setting.lokasi_absen.index', compact('datas', 'divisi'))->with('no');
    }

    public function store(Request $request)
    {
        LokasiAbsen::create([
            'divisi_id' => $request->divisi_id,
            'lat' => $request->lat,
            'long' => $request->long,
            'jarak_toleransi' => $request->jarak_toleransi
        ]);
        return back()->with('success', 'Data lokasi absen berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        LokasiAbsen::find($id)->update([
            'lat' => $request->lat,
            'long' => $request->long,
        ]);
        return back()->with('success', 'Data lokasi absen berhasil diperbarui');
    }

    public function destroy($id)
    {
        LokasiAbsen::find($id)->delete();
        return back()->with('success', 'Data lokasi absen berhasil dihapus');
    }
}
