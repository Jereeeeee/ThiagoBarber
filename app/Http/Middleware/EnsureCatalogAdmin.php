<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCatalogAdmin
{
    /**
     * Permitir solo usuarios autenticados con rol administrativo.
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            return redirect()
                ->route('login')
                ->with('error', 'Debes iniciar sesion para gestionar el catalogo.');
        }

        if (! in_array((int) $user->role_id, [1, 3], true)) {
            return redirect()
                ->route('home')
                ->with('error', 'No tienes permisos para gestionar el catalogo.');
        }

        return $next($request);
    }
}
