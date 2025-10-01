<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAlumni
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated with 'alumni' guard
        if (!Auth::guard('alumni')->check()) {
            // Redirect to alumni login if not authenticated
            return redirect()->route('alumni.login');
        }

        // Check if alumni is trying to access admin routes
        if ($request->is('admin/*')) {
            // Alumni trying to access admin area - redirect to alumni dashboard
            return redirect()->route('alumni.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke area admin.');
        }

        return $next($request);
    }
}
