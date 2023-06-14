<?php

namespace App\Http\Controllers;

use App\Models\KaryawanRoster;
use App\Models\PeriodeRoster;
use Illuminate\Http\Request;

class PeriodeRosterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = PeriodeRoster::orderBy('id', 'DESC')->get();
        return view('customize_setting.periode_roster.index', compact('datas'))->with('no');
    }

    public function store(Request $request)
    {
        try {
            PeriodeRoster::create([
                'awal_periode' => $request->awal_periode,
                'akhir_periode' => $request->akhir_periode,
            ]);
            return back()->with('success', 'Periode berhasil ditambahkan');
        } catch (\Throwable $e) {
            return back()->with('error', 'Upss, Terjadi kesalahan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            PeriodeRoster::where('id', $id)->update([
                'awal_periode' => $request->awal_periode,
                'akhir_periode' => $request->akhir_periode,
            ]);
            return back()->with('success', 'Periode berhasil diperbarui');
        } catch (\Throwable $e) {
            return back()->with('error', 'Upss, Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PeriodeRoster  $periodeRoster
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PeriodeRoster::findorFail($id)->delete();
        return back()->with('success', 'Periode berhasil dihapus');
    }
}
