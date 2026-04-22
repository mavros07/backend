<?php

namespace App\Http\Middleware;

use App\Models\AdminAuditTrail;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackAdminAuditTrail
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->user() || ! $request->user()->hasRole('admin')) {
            return $response;
        }

        if (! in_array(strtoupper($request->method()), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            return $response;
        }

        try {
            AdminAuditTrail::query()->create([
                'user_id' => $request->user()->id,
                'method' => strtoupper($request->method()),
                'path' => '/'.ltrim((string) $request->path(), '/'),
                'route_name' => optional($request->route())->getName(),
                'status_code' => (int) $response->getStatusCode(),
                'ip_address' => (string) $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 1000),
                'meta' => [
                    'query' => $request->query(),
                ],
            ]);
        } catch (\Throwable) {
            // Fail open: audit logging should never block admin actions.
        }

        return $response;
    }
}

