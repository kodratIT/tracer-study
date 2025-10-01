<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated with 'web' guard (admin)
        if (!Auth::guard('web')->check()) {
            // Redirect to admin login if not authenticated
            return redirect()->route('filament.admin.auth.login');
        }

        // Check if user is trying to access alumni routes
        if ($request->is('alumni/*')) {
            // Admin trying to access alumni area - redirect to admin dashboard
            return redirect()->route('filament.admin.pages.dashboard')
                ->with('error', 'Anda sudah login sebagai admin.');
        }

        return $next($request);
    }
}
