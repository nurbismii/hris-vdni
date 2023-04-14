<?php

namespace App\Http\Middleware;

use App\Models\employee;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EmployeesRegistered
{
    public function handle(Request $request, Closure $next)
    {
        $employe_exist = employee::where('nik', $request->employee_id)->first();
        $user_exist = User::where('employee_id', $request->employee_id)->first();

        if ($user_exist) {
            return back()->with('error', 'NIK Karyawan telah digunakan');
        }

        if (!$employe_exist) {
            return back()->with('error',  'NIK Karyawan tidak ditemukan di database kami, silahkan laporkan ini ke HRD');
        }
        return $next($request);
    }
}
