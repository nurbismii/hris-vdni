<?php

namespace App\Http\Controllers;

use App\Exports\DivisiExport;
use App\Imports\DivisiImport;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DivisiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $divisi = $request['divisi'];
        $count = count($divisi);

        for ($i = 0; $i < $count; $i++) {
            $datas[] = [
                'nama_divisi' => $divisi[$i],
                'departemen_id' => $request->departemen_id
            ];
        }
        Divisi::insert($datas);
        return back()->with('success', 'Data divisi berhasil ditambahkan');
    }

    public function update($id, Request $request)
    {
        Divisi::where('id', $id)->update([
            'nama_divisi' => $request->divisi
        ]);
        return back()->with('success', 'Data divisi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Divisi  $divisi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Divisi::where('id', $id)->delete();
        return back()->with('success', 'Berhasil menghapus divisi');
    }

    public function exportDivisi()
    {
        return Excel::download(new DivisiExport, 'divisi.xlsx');
    }
}
