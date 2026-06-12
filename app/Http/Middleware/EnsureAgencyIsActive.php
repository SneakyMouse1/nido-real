<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAgencyIsActive
{
    /**
     * Check that the current tenant (agency) is active.
     * If suspended, show a blocked page.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = Filament::getTenant();

        if ($tenant && !$tenant->is_active) {
            return response()->view('filament.agency-suspended', [], 403);
        }

        return $next($request);
    }
}
