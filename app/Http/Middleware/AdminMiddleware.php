<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // Importa la fachada Auth

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y si su rol es 'admin'
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request); // Si es admin, permite el acceso
        }

        // Si no es admin o no está autenticado, redirige o aborta
        // Puedes redirigir a un dashboard, a la página de inicio, o mostrar un error 403
        return redirect('/dashboard')->with('error', 'Acceso no autorizado. Necesitas permisos de administrador.');
        // O si prefieres un error 403 Forbidden:
        // abort(403, 'Acceso no autorizado.');
    }
}
