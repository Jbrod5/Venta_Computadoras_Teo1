<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\TipoUsuario;
use App\Helpers\Encriptador; 

class UsuariosAdminController extends Controller
{
    // Listado de usuarios
    public function index()
    {
        $usuarios = Usuario::with('tipo')->get();
        return view('admin.usuarios.iniciousuarios', compact('usuarios'));
    }

    // Formulario para crear usuario
    public function create()
    {
        $roles = TipoUsuario::all();
        return view('admin.usuarios.create', compact('roles'));
    }

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:200',
            'correo' => 'required|email|unique:usuario,correo',
            'pass' => 'required|string|min:4',
            'direccion' => 'required|string|max:300',
            'telefono' => 'required|numeric',
            'id_tipo_usuario' => 'required|exists:tipo_usuario,id_tipo_usuario'
        ]);

        Usuario::create([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'pass' => Encriptador::encriptar($request->correo, $request->pass),
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'id_tipo_usuario' => $request->id_tipo_usuario
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    // Mostrar un usuario
    public function show(Usuario $usuario)
    {
        return view('admin.usuarios.show', compact('usuario'));
    }

    // Formulario para editar usuario
    public function edit(Usuario $usuario)
    {
        $roles = TipoUsuario::all();
        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    // Actualizar usuario
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:200',
            'correo' => 'required|email|unique:usuario,correo,' . $usuario->id_usuario . ',id_usuario',
            'direccion' => 'required|string|max:300',
            'telefono' => 'required|numeric',
            'id_tipo_usuario' => 'required|exists:tipo_usuario,id_tipo_usuario'
        ]);

        $datos = [
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'id_tipo_usuario' => $request->id_tipo_usuario,
        ];

        // Solo si se envía una nueva contraseña, se encripta y se guarda
        if (!empty($request->pass)) {
            $datos['pass'] = Encriptador::encriptar($request->correo, $request->pass);
        }

        $usuario->update($datos);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // Eliminar usuario
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}
