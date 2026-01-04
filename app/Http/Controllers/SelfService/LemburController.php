<?php

namespace App\Http\Controllers\SelfService;

use App\Http\Controllers\Controller;
use App\Models\Lembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LemburController extends Controller
{
    public function index()
    {
        $data =  Lembur::with('karyawan')
            ->leftJoin('employees', 'employees.nik', '=', 'lembur.nik_karyawan')
            ->where('lembur.nik_karyawan', Auth::user()->nik_karyawan)
            ->orderBy('lembur.created_at', 'desc')
            ->select(
                'lembur.*',
                'employees.nama_karyawan',
                'employees.no_telp',
                'employees.divisi_id',
                DB::raw('TIMESTAMPDIFF(HOUR, STR_TO_DATE(lembur.mulai_lembur, "%H:%i"), STR_TO_DATE(lembur.berakhir_lembur, "%H:%i")) as selisih_lembur')
            )->get();


        return view('user.lembur.index', compact('data'));
    }

    public function show($id)
    {
        $data = Lembur::with('karyawan')
            ->leftJoin('employees', 'employees.nik', '=', 'lembur.nik_karyawan')
            ->where('employees.divisi_id', Auth::user()->employee->divisi_id)
            ->where('lembur.id', $id)
            ->orderBy('lembur.created_at', 'desc')
            ->select(
                'lembur.*',
                'employees.nama_karyawan',
                'employees.no_telp',
                'employees.divisi_id',
                DB::raw('TIMESTAMPDIFF(HOUR, STR_TO_DATE(lembur.mulai_lembur, "%H:%i"), STR_TO_DATE(lembur.berakhir_lembur, "%H:%i")) as selisih_lembur')
            )->first();

        return view('user.lembur.show', compact('data'));
    }

    public function update(Request $request, $id)
    {
        //
        Lembur::where('id', $id)->update([
            'persetujuan_karyawan' => $request->persetujuan_karyawan
        ]);
        return back()->with('success', 'Kamu menyetujui permintaan lembur');
    }
}
