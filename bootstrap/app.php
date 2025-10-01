<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(function () {
            return route('filament.admin.auth.login');
        });
        
        // Register middleware aliases
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'alumni' => \App\Http\Middleware\EnsureUserIsAlumni::class,
            'redirect.role' => \App\Http\Middleware\RedirectIfNotAlumni::class,
            'filament.admin' => \App\Http\Middleware\FilamentAdminAuth::class,
        ]);
        
        $middleware->web(append: [
            \App\Http\Middleware\RedirectIfNotAlumni::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
