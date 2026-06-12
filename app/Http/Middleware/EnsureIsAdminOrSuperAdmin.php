<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdminOrSuperAdmin
{
    /**
     * Ensure the authenticated user has an admin or superadmin role.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !$user->hasAnyRole(['superadmin', 'admin'])) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        return $next($request);
    }
}
