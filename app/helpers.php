<?php

use App\Services\SettingsService; // <-- 1. Importamos el servicio que vamos a usar.

if (! function_exists('setting')) {
    /**
     * Obtiene un valor de configuración de la base de datos a través del SettingsService.
     *
     * @param string $key La clave de la configuración a obtener.
     * @param mixed|null $default El valor por defecto a devolver si la clave no existe.
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        // 2. Esta es la lógica final.
        //    app(SettingsService::class) le pide al contenedor de servicios de Laravel
        //    que nos dé la instancia única (singleton) del SettingsService.
        //    Luego, simplemente llamamos a su método get().
        return app(SettingsService::class)->get($key, $default);
    }
}