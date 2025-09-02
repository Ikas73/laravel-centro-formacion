<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SettingsService; // <-- Importa la clase

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registramos SettingsService como un "singleton".
        // Esto significa que Laravel creará la instancia una sola vez
        // por cada petición y reutilizará esa misma instancia
        // cada vez que se solicite, mejorando el rendimiento.
        $this->app->singleton(SettingsService::class, function ($app) {
            return new SettingsService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // No necesitamos nada aquí por ahora.
    }
}