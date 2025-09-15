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

        // Buscar usuario por correo
        //Esta es la consulta a la base de datos :3
        $usuario = Usuario::where('correo', $email)->first();

        if (!$usuario) {
            return response()->json(['error' => 'Correo no registrado'], 401);
        }

        // Comparar contraseñas (por ahora en texto plano)
        if ($usuario->pass !== $password) {
            return response()->json(['error' => 'Contraseña incorrecta >:c'], 401);
        }

        //Si llego hasta aquí todo está bien :3

        // Iniciar sesión
        Auth::login($usuario);

        return response()->json([
            'success' => true,
            'user' => $usuario->nombre,
            'tipo_usuario' => $usuario->id_tipo_usuario,
            'redirect' => url('/usuarios') // Vue puede leer esta URL y redirigir
        ]);

    }
}
