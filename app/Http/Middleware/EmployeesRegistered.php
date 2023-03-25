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
            return back()->with('error', 'User registered');
        }

        if (!$employe_exist) {
            return back()->with('error',  'Emplooye data is not registered in our database');
        }
        return $next($request);
    }
}
