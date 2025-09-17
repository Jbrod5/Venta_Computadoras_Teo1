<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        // Buscar usuario
        $usuario = Usuario::where('correo', $email)->first();

        if (!$usuario) {
            return back()->withErrors(['email' => 'Correo no registrado']);
        }

        // Contraseña en texto plano por ahora
        if ($usuario->pass !== $password) {
            return back()->withErrors(['password' => 'Contraseña incorrecta']);
        }

        // Iniciar sesión con Laravel Auth
        Auth::login($usuario);

        // Redirigir según rol
        if ($usuario->id_tipo_usuario == 1) {
            return redirect('/admin');
        } elseif ($usuario->id_tipo_usuario == 2) {
            return redirect('/tecnico');
        } else {
            return redirect('/catalogo');
        }
    }
}
