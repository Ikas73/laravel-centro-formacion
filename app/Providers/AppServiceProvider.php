<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- ESTA ES LA LÍNEA QUE FALTA

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Forzamos el esquema HTTPS si el entorno es 'production'
        // Puedes quitar el if si quieres que se aplique siempre.
        if ($this->app->environment('CF-Connecting-IP')) {
             URL::forceScheme('https');
        }
    }
}