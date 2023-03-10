<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()) {
            return $next($request);
        }

        return redirect('login')->with('error', 'Oops, Please login first');
    }
}
