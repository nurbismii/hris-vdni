<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountUpdateRequest;
use App\Models\Contract;
use App\Models\salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        $total_diterima = salary::where('employee_id', Auth::user()->employee_id)->latest()->first('total_diterima');
        $contract = Contract::where('nik', Auth::user()->employee_id)->latest()->first('tanggal_berakhir_kontrak');
        return view('account.billing', compact('datas', 'total_diterima', 'contract'));
    }

    public function show($id)
    {
        $data = salary::where('id', $id)->first();
        return view('account.invoice', compact('data'));
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
}
