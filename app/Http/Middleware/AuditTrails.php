<?php

namespace App\Http\Middleware;

use App\Models\AuditTrail;
use Closure;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class AuditTrails
{
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
                'response' => app('Illuminate\Http\Response')->status()
            ];
            AuditTrail::create($log);
            return $response;
        } catch (\Throwable $e) {
            $log = [
                'id' => Uuid::uuid4()->getHex(),
                'url' => $request->segment(2) == 'server-side' ? 'server-side' : $request->getUri(),
                'method' => $request->getMethod(),
                'ip' => $request->ip(),
                'agent' => $request->header('user-agent'),
                'request_body' => json_encode($request->except(['image_employee'])),
                'response' => app('Illuminate\Http\Response')->status()
            ];
            AuditTrail::create($log);
        }
    }
}
