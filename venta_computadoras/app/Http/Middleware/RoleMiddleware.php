<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/'); // si no está logueado
        }

        $user = Auth::user();

        // Validar rol
        if ($user->id_tipo_usuario != $this->mapRole($role)) {
            abort(403, 'Acceso denegado');
        }

        return $next($request);
    }

    private function mapRole($role)
    {
        return match ($role) {
            'admin' => 1,
            'tecnico' => 2,
            'cliente' => 3,
            default => null
        };
    }
}
