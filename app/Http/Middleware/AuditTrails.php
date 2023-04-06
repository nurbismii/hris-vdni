<?php

namespace App\Http\Middleware;

use App\Models\AuditTrail;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PSpell\Config;
use Ramsey\Uuid\Uuid;

class AuditTrails
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

        try {
            $log = [
                'id' => Uuid::uuid4()->getHex(),
                'url' => $request->segment(2) == 'server-side' ? 'server-side' : $request->getUri(),
                'method' => $request->getMethod(),
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'request_body' => json_encode($request->except(['image_employee'])),
                'response' => ''
            ];
            AuditTrail::create($log);
            return $response;
        } catch (\Throwable $e) {
            $res = [
                'status_code' => 500,
                'status' => false,
                'Flag' => 'Log Activity',
                'message' => $e->getMessage(),
            ];
            return response()->json($res, 500);
        }
    }
}
