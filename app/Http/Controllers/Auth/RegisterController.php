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
        try {
            $employee = employee::where('nik', $request->employee_id)->first();
            if ($request->password == $request->password_confirm) {
                $data_user = array(
                    'id' => Uuid::uuid4()->getHex(),
                    'employee_id' => $request->employee_id,
                    'name' => $employee->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'status' => 'Not Active',
                );
                User::create($data_user);
                return back()->with('success', 'Successful registration, ');
            }
        } catch (\Throwable $e) {
            return back()->with('error', 'Something wrong!');
        }
    }
}
