<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectorHubInd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $cek_role = Auth::user()->job->permission_role ?? '';
        if ($cek_role) {
            if (strtolower($cek_role) == 'hubungan industrial' || strtolower($cek_role) == 'administrator') {
                return $next($request);
            }
            abort(403);
        }
        if (!$cek_role) {
            return response()->view('forbidden');
        }
    }
}
