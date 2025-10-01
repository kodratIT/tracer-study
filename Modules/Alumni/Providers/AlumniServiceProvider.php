<?php

namespace Modules\Alumni\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AlumniServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register Blade components
        Blade::componentNamespace('Modules\\Alumni\\View\\Components', 'alumni');
        
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'alumni');
        
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        
        // Publish resources
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/alumni'),
        ], 'alumni-views');
    }

    public function register()
    {
        //
    }
}
