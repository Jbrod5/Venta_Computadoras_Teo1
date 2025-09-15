<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function store(Request $request)
    {
        // Validación básica
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuario,correo', // tabla "usuario"
            'pass' => 'required|string|min:5',
            'direccion' => 'required|string',
            'telefono' => 'required|numeric',
        ]);

        // Crear usuario como cliente
        $usuario = Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'pass' => $request->pass, // encriptar contraseña
            'direccion'=> $request->direccion, 
            'telefono' => $request->telefono,
            'id_tipo_usuario' => 3 // El cliente es tipo 3
        ]);

        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => $usuario->nombre
        ]);
    }
}
