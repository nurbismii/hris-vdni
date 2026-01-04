<?php

namespace App\Http\Controllers\SelfService;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class SlipGajiController extends Controller
{
    //
    public function index()
    {
        $check_exist = DB::connection('epayslip')->table('data_karyawans')->select('id', 'nik', 'nama')
            ->where('nik', Auth::user()->nik_karyawan)->first();

        if (!$check_exist) {
            return back()->with('info', 'Informasi yang kamu minta belum tersedia');
        }

        $gaji_karyawan = DB::connection('epayslip')->table('komponen_gajis')->select('*')
            ->where('data_karyawan_id', $check_exist->id)->latest()->first();

        $datas = DB::connection('epayslip')->table('komponen_gajis')->select('*')
            ->orderBy('periode', 'DESC')
            ->where('data_karyawan_id', $check_exist->id)->limit(6)->get();

        $contract = Contract::where('nik', Auth::user()->nik_karyawan)->latest()->first('tanggal_berakhir_kontrak');

        return view('user.slip-gaji.index', compact('datas', 'gaji_karyawan', 'contract'));
    }

    public function show($id)
    {
        $check_exist = DB::connection('epayslip')->table('data_karyawans')->select('id', 'nik', 'nama')
            ->where('nik', Auth::user()->nik_karyawan)->first();

        $data = DB::connection('epayslip')->table('komponen_gajis')->select('*')
            ->where('data_karyawan_id', $check_exist->id)
            ->where('id', $id)
            ->first();

        $gaji_karyawan = DB::connection('epayslip')->table('komponen_gajis')->select('*')
            ->where('data_karyawan_id', $check_exist->id)->latest()->first();

        $total_deduction = $data->jht + $data->jp + $data->pot_bpjskes + $data->unpaid_leave + $data->deduction_pph21;
        $total_diterima = ($data->gaji_pokok + $data->tunj_um + $data->tunj_pengawas + $data->tunj_transport + $data->tunj_mk + $data->tunj_koefisien + $data->rapel + $data->insentif + $data->tunj_lap);
        $gaji_bersih = ($total_diterima - $total_deduction);

        return view('user.slip-gaji.show', compact('data', 'check_exist', 'total_diterima', 'total_deduction', 'gaji_bersih', 'gaji_karyawan'));
    }

    public function cetak_pdf($id)
    {
        $check_exist = DB::connection('epayslip')->table('data_karyawans')->select('id', 'nik', 'nama')
            ->where('nik', Auth::user()->nik_karyawan)->first();

        $data = DB::connection('epayslip')->table('komponen_gajis')->select('*')
            ->where('data_karyawan_id', $check_exist->id)
            ->where('id', $id)
            ->first();

        $total_deduction = $data->jht + $data->jp + $data->pot_bpjskes + $data->unpaid_leave + $data->deduction_pph21;
        $total_diterima = ($data->gaji_pokok + $data->tunj_um + $data->tunj_pengawas + $data->tunj_transport + $data->tunj_mk + $data->tunj_koefisien + $data->rapel + $data->insentif + $data->tunj_lap);
        $gaji_bersih = ($total_diterima - $total_deduction);

        $pdf = PDF::loadView('account.invoice_pdf', compact('data', 'check_exist', 'gaji_bersih', 'total_diterima', 'total_deduction'))->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
