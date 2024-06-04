<?php

namespace App\Http\Controllers\User;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UsertUpdaterRequest;
use App\Imports\UsersImport;
use App\Models\employee;
use App\Models\role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;
use Ramsey\Uuid\Uuid;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $datas = User::orderBy('nik_karyawan', 'DESC')->take(1000)->get();
        return view('user.index', compact('datas'));
    }

    public function serverSide()
    {
        return DataTables::of(User::with('role'))->addColumn('action', function ($row) {
            $actionBtn =
                '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> 
                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';

            return $actionBtn;
        })->rawColumns(['action'])->make(true);
    }

    public function create()
    {
        $roles = role::all();
        return view('user.create', compact('roles'));
    }

    public function import()
    {
        return view('user.import');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|unique:users,email',
                'nik_karyawan' => 'required|unique:users,nik_karyawan'
            ]);

            if ($validator->fails()) {
                return back()->with('error', 'NIK atau Email telah terdaftar!');
            }

            $cek_karyawan = employee::where('nik', $request->nik_karyawan)->first();

            if (!$cek_karyawan) {
                return back()->with('error', 'NIK yang didaftarkan belum terdaftar sebagai karyawan PT. VDNI');
            }

            User::create([
                'id' => Uuid::uuid4()->getHex(),
                'nik_karyawan' => $request->nik_karyawan,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => $request->status,
                'role_id' => $request->role_id,
            ]);
            return back()->with('success', 'Pengguna baru berhasil ditambahkan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan!');
        }
    }

    public function edit($id)
    {

        try {
            $data = User::with('employee')->where('nik_karyawan', $id)->first();

            $level_vaksin = $data->employee->vaksin == '0' ? 'Belum Vaksin' : ($data->employee->vaksin == '1' ? 'Vaksin 1' : ($data->employee->vaksin == '2' ? 'Vaksin 2' : ($data->employee->vaksin == '3' ? 'Booster 1' : ($data->employee->vaksin == '4' ? 'Booster 2' : 'Tidak diketahui'))));

            $status_perkawinan = '';
            if ($data->employee->status_perkawinan == 'Belum Kawin') {
                $status_perkawinan = $data->employee->status_perkawinan;
            }

            return view('user.edit', compact('data', 'level_vaksin'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan!');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            if ($request->password == $request->konfirmasi_password && $request->password != '') {
                $password_baru = $request->password;
                User::where('nik_karyawan', $id)->update([
                    'email' => $request->email,
                    'status' => $request->status,
                    'password' => Hash::make($password_baru),
                ]);
                return redirect('users')->with('success', 'Pengguna berhasil diperbarui');
            }
            if ($request->password != $request->konfirmasi_password) {
                return back()->with('error', 'Password konfirmasi tidak sesuai');
            }
            User::where('nik_karyawan', $id)->update([
                'email' => $request->email,
                'status' => $request->status,
            ]);
            return redirect('users')->with('success', 'Pengguna berhasil diperbarui');
        } catch (\Throwable $e) {
            return redirect('users')->with('error', 'Something wrong!');
        }
    }

    public function destroy($id)
    {
        try {
            User::where('nik_karyawan', $id)->delete();
            return back()->with('success', 'Pengguna berhasil dihapus');
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan!' . $e->getMessage());
        }
    }

    public function lastLogin(Request $request)
    {
        try {
            $datas = User::where('terakhir_login', '!=', null)->get();
            return view('user.lastlogin', compact('datas'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan!');
        }
    }

    public function downloadExampleUser()
    {
        return Excel::download(new UserExport, 'User-Tempalate.xlsx');
    }

    public function importUser(Request $request)
    {
        Excel::import(new UsersImport, $request->file('file'));
        return back()->with('success', 'Impor pengguna berhasil');
    }
}
