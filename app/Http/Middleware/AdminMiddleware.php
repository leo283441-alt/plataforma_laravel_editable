<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Maneja la solicitud entrante.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y es admin
        if (!auth()->check() || auth()->user()->rol !== 'admin') {
            abort(403, 'Acceso denegado. Solo los administradores pueden acceder.');
        }

        return $next($request);
    }
}
