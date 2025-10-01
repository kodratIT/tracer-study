<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FilamentAdminAuth
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

        // If alumni user tries to access admin panel directly
        if (Auth::guard('alumni')->check()) {
            Auth::guard('alumni')->logout();
            $request->session()->invalidate();
            return redirect()->route('filament.admin.auth.login')
                ->with('error', 'Anda harus login sebagai admin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
