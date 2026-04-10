<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AuthRateLimitServiceProvider extends ServiceProvider
{
    /**
     * Registrar los limites de intentos para autenticacion y registro.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->defineLoginLimit();
        $this->defineRegisterLimit();
        $this->definePasswordResetRequestLimit();
        $this->definePasswordResetVerifyLimit();
    }

    /**
     * Configurar el limite de intentos para inicio de sesion.
     *
     * @return void
     */
    private function defineLoginLimit(): void
    {
        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->input('email');

            return Limit::perMinute(5)->by($email . '|' . $request->ip());
        });
    }

    /**
     * Configurar el limite de intentos para registro.
     *
     * @return void
     */
    private function defineRegisterLimit(): void
    {
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(3)
                ->by((string) $request->ip())
                ->response(function (Request $request, array $headers) {
                    return back()->withErrors([
                        'rate_limit' => 'Demasiados intentos de registro. Por seguridad, espera un minuto antes de volver a intentarlo.',
                    ]);
                });
        });
    }

    /**
     * Configurar el limite de solicitudes para envio de codigo de recuperacion.
     *
     * @return void
     */
    private function definePasswordResetRequestLimit(): void
    {
        RateLimiter::for('password-reset-request', function (Request $request) {
            $email = (string) $request->input('email');

            return Limit::perMinute(3)
                ->by($email.'|'.$request->ip())
                ->response(function () {
                    return back()->withErrors([
                        'email' => 'Has solicitado demasiados codigos. Espera un minuto para intentar nuevamente.',
                    ])->withInput();
                });
        });
    }

    /**
     * Configurar el limite de intentos para verificacion de codigo.
     *
     * @return void
     */
    private function definePasswordResetVerifyLimit(): void
    {
        RateLimiter::for('password-reset-verify', function (Request $request) {
            $email = (string) $request->input('email');

            return Limit::perMinute(10)
                ->by($email.'|'.$request->ip())
                ->response(function () {
                    return back()->withErrors([
                        'code' => 'Demasiados intentos de verificacion. Espera un minuto para reintentar.',
                    ])->withInput();
                });
        });
    }
}
