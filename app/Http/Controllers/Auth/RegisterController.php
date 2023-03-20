<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRegisterRequest;
use App\Models\employee;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    public function register(Request $request)
    {
        $employe_exist = employee::where('nik', $request->employee_id)->first();
        if (!$employe_exist)
            return back()->with('error',  'Emplooye data is not registered in our database');
        $data_user = array(
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
            'status' => 'NOT ACTIVE',
        );
        User::create($data_user);
        return back()->with('success', 'Successful registration');
        try {
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }
}
