<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendEmailResetPassword;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    public function resetPassword(Request $request)
    {
        $check_user = User::where('email', $request->email)->first();

        if (!$check_user) {
            return back()->with('error', 'Email tidak terdaftar');
        }

        

        $check_user->update([
            'updated_at' => date('Y-m-d H:i:s', strtotime(Carbon::now())),
        ]);

        Mail::to($check_user->email)->send(new SendEmailResetPassword($check_user));
        return back()->with('success', 'Silahkan cek inbox email kamu, untuk melakukan reset kata sandi');
    }


    public function setPassword($id)
    {
        $user = User::where('id', $id)->firstorFail();

        return view('auth.reset-password', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        if ($request->password === $request->repeat_password) {
            User::where('id', $id)->update([
                'password' => bcrypt($request->password),
            ]);
            return redirect('/login')->with('success', 'Berhasil melakukan reset kata sandi, silahkan masuk!');
        }
        return back()->with('error', 'Konfirmasi kata sandi tidak sesuai, sesuaikan dengan kata sandi');
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
