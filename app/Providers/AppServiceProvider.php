<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registrar los servicios de la aplicacion.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Inicializar la configuracion global de la aplicacion.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
