<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckForcePasswordChange
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->force_password_change === true) {
            // Allow access to password change page only
            if ($request->routeIs('password.change') || $request->routeIs('password.update') || $request->routeIs('logout')) {
                return $next($request);
            }

            // Redirect to password change page
            return redirect()->route('password.change');
        }

        return $next($request);
    }
}
