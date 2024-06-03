<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountUpdateRequest;
use App\Models\Contract;
use App\Models\CutiIzin;
use App\Models\CutiRoster;
use App\Models\Divisi;
use App\Models\employee;
use App\Models\GajiKaryawan;
use App\Models\salary;
use App\Models\User;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $datas = User::with('employee')->where('nik_karyawan', Auth::user()->nik_karyawan)->first();
        $divisi = Divisi::with('departemen')->where('id', $datas->employee->divisi_id)->first();
        return view('account.profile', compact('datas', 'divisi'));
    }

    public function slipgaji()
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

        return view('account.billing', compact('datas', 'gaji_karyawan', 'contract'));
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

        return view('account.invoice', compact('data', 'check_exist', 'total_diterima', 'total_deduction', 'gaji_bersih', 'gaji_karyawan'));
    }

    public function update(AccountUpdateRequest $request, $id)
    {
        try {
            $email_exist = User::where('email', $request->email)->first();
            if ($email_exist) {
                return back()->with('error', 'Email has been used');
            }
            User::where('nik_karyawan', $id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
            return back()->with('success', 'Your account has been updated');
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }

    public function contract()
    {
        try {
            $contract = Contract::where('nik', Auth::user()->employee_id)->first();
            if (!$contract) {
                return back()->with('error', 'Kamu tidak memiliki kontrak saat ini');
            }
            return view('account.contract', compact('contract'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
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

    public function pengajuan()
    {
        $datas = CutiIzin::orderBy('created_at', 'DESC')->where('nik_karyawan', Auth::user()->nik_karyawan)->limit(6)->get();
        return view('account.pengajuan', compact('datas'));
    }

    public function tiket()
    {
        $datas = CutiRoster::where('nik_karyawan', Auth::user()->employee->nik)->get();
        return view('tiket.index', compact('datas'));
    }

    public function updateAkun(Request $request, $id)
    {
        if ($request->password != $request->password_confirm) {
            return back()->with('error', 'Konfirmasi kata sandi tidak sesuai, silahkan coba lagi');
        }

        User::where('nik_karyawan', $id)->update(
            [
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ],
        );

        return back()->with('success', 'Berhasil melakukan perubahan');
    }

    public function statusPermohonan()
    {
        $cuti = CutiRoster::join('employees', 'employees.nik', '=', 'cuti_roster.nik_karyawan')
            ->join('periode_kerja_roster', 'periode_kerja_roster.cuti_roster_id', '=', 'cuti_roster.id')
            ->orderBy('cuti_roster.id', 'desc')
            ->select('cuti_roster.*', 'employees.nama_karyawan',  'periode_kerja_roster.tipe_rencana')
            ->get();

        return view('account/permohonan-cuti-roster', compact('cuti'));
    }
}
