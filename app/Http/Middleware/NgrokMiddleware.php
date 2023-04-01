<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NgrokMiddleware
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
        $response = $next($request);
        
        $request->header('ngrok-skip-browser-warning', '131196');

        return $response;
    }
}
