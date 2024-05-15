<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Mail\SendEmailVerification;
use App\Models\employee;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(StoreRegisterRequest $request)
    {
        DB::beginTransaction();
        $employee = employee::where('nik', $request->employee_id)->first();

        $check_user = User::where('nik_karyawan', $request->employee_id)->first();

        if ($check_user) {
            return back()->with('info', 'Akun pengguna telah tersedia, laporkan ini ke kantor HRD');
        }

        if ($request->password == $request->password_confirm) {
            $data_user = array(
                'id' => Uuid::uuid4()->getHex(),
                'nik_karyawan' => $request->employee_id,
                'name' => $employee->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 'Tidak Aktif',
            );
            $user = User::create($data_user);
            Mail::to($request->email)->send(new SendEmailVerification($user));
            DB::commit();
            return redirect('login')->with('success', 'Silahkan verifikasi email kamu.');
        }
        try {
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan!');
        }
    }

    public function konfirmasiEmail($nik_karyawan)
    {
        $check = User::where('nik_karyawan', $nik_karyawan)->first();
        if (strtolower($check->status) == 'aktif') {
            return redirect('login')->with('warning', 'Verifikasi ini telah digunakan');
        }
        User::where('nik_karyawan', $nik_karyawan)->update([
            'email_verified_at' => Carbon::now(),
            'status' => 'aktif'
        ]);
        return view('200');
    }
}
