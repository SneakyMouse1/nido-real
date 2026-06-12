<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAgentOrManager
{
    /**
     * Ensure the authenticated user has an agent or agency_manager role.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasAnyRole(['agency_manager', 'agent'])) {
            abort(403, 'Access denied. Agency privileges required.');
        }

        return $next($request);
    }
}
