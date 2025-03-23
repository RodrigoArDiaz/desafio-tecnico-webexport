<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y si es superAdministrador
        if (auth()->check() && auth()->user()->esSuperAdministrador() ) {
            return $next($request); // Permite continuar
        }

        // Si no es superAdministrador, devuelve un error 403 (Prohibido)
        return response()->json(['message' => 'Acceso denegado: se requieren privilegios para acceder a esta pagina.'], 403);
    }
}
