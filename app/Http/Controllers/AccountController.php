<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountUpdateRequest;
use App\Models\Contract;
use App\Models\salary;
use App\Models\User;
use PDF;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {

        return view('account.profile');
    }

    public function billing()
    {
        $datas = salary::where('employee_id', Auth::user()->employee_id)->get();
        $salary = salary::where('employee_id', Auth::user()->employee_id)->latest()->first('gaji_pokok');
        $contract = Contract::where('nik', Auth::user()->employee_id)->latest()->first('tanggal_berakhir_kontrak');
        return view('account.billing', compact('datas', 'salary', 'contract'));
    }

    public function show($id)
    {
        $data = salary::where('id', $id)->first();

        $total_deduction = $data->jht + $data->jp + $data->bpjs_kesehatan + $data->deduction_unpaid_leave + $data->deduction_php21;

        $total_diterima = ($data->gaji_pokok + $data->tunjangan_umum + $data->tunjangan_pengawas + $data->tunjangan_transport + $data->tunjangan_mk + $data->tunjangan_koefisien + $data->rapel + $data->insentif + $data->tunjangan_lap);

        $gaji_bersih = ($total_diterima - $total_deduction);

        return view('account.invoice', compact('data', 'total_diterima', 'total_deduction', 'gaji_bersih'));
    }

    public function update(AccountUpdateRequest $request, $id)
    {
        try {
            $email_exist = User::where('email', $request->email)->first();
            if ($email_exist) {
                return back()->with('error', 'Email has been used');
            }
            User::where('employee_id', $id)->update([
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

    public function cetak_pdf($employe_id)
    {
        $data = salary::where('employee_id', $employe_id)->first();

        $total_deduction = $data->jht + $data->jp + $data->bpjs_kesehatan + $data->deduction_unpaid_leave + $data->deduction_php21;

        $total_diterima = ($data->gaji_pokok + $data->tunjangan_umum + $data->tunjangan_pengawas + $data->tunjangan_transport + $data->tunjangan_mk + $data->tunjangan_koefisien + $data->rapel + $data->insentif + $data->tunjangan_lap);

        $gaji_bersih = ($total_diterima - $total_deduction);

        $pdf = PDF::loadView('account.invoice_pdf', compact('data', 'gaji_bersih', 'total_diterima', 'total_deduction'));
        return $pdf->download('slip-gaji' . $data->mulai_periode . ' ' . $data->akhir_periode . '.pdf');
        try {
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }
}
