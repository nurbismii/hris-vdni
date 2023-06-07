<?php

namespace App\Http\Controllers;

use App\Models\WaktuAbsen;
use Illuminate\Http\Request;

class WaktuAbsenController extends Controller
{
    public function index()
    {
        $datas = WaktuAbsen::orderBy('tipe', 'asc')->get();
        return view('customize_setting.waktu_absen.index', compact('datas'));
    }


    public function storeWaktuAbsen(Request $request)
    {
        WaktuAbsen::create([
            'nama_shift' => $request->nama_shift,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'tipe' => $request->tipe,
            'keterangan' => $request->keterangan,
        ]);
        return back()->with('success', 'Data waktu kerja berhasil ditambahkan');
    }


    public function update(Request $request, $id)
    {
        WaktuAbsen::where('id', $id)->update([
            'nama_shift' => $request->nama_shift,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar,
            'tipe' => $request->tipe,
            'keterangan' => $request->keterangan,
        ]);
        return back()->with('success', 'Data waktu kerja berhasil diperbarui');
    }

    public function destroy(WaktuAbsen $waktuAbsen)
    {
        //
    }
}
