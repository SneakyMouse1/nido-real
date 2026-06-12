<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Set the application locale from session, user preference, or config default.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Determine locale from session, authenticated user preference, or app config
        $locale = session('locale')
            ?? auth()->user()?->locale
            ?? config('app.locale');

        if (in_array($locale, ['es', 'en'])) {
            app()->setLocale($locale);
            session(['locale' => $locale]);
        }

        return $next($request);
    }
}
