<?php

namespace App\Http\Middleware;

use App\Models\PageVisit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrackVisitMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->isMethod('GET')) {
            try {
                $ip = $request->ip();
                $hostname = gethostbyaddr($ip);

                PageVisit::create([
                    'visited_at' => now(),
                    'page'       => $request->fullUrl(),
                    'ip_address' => $ip,
                    'hostname'   => $hostname !== $ip ? $hostname : null,
                    'user_agent' => $request->userAgent(),
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to track visit: ' . $e->getMessage());
            }
        }

        return $response;
    }
}
