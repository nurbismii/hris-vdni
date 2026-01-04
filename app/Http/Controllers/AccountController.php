<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountUpdateRequest;
use App\Models\Contract;
use App\Models\CutiIzin;
use App\Models\CutiRoster;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function profile()
    {
        $datas = User::with('employee')->where('nik_karyawan', Auth::user()->nik_karyawan)->first();
        $divisi = Divisi::with('departemen')->where('id', $datas->employee->divisi_id)->first();
        return view('account.profile', compact('datas', 'divisi'));
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
}
