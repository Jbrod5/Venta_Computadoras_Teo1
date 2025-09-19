<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ensamble;
use App\Models\Componente;
use Illuminate\Support\Facades\Auth;

class ComponentesEnsamblesController extends Controller
{
    public function index() {
    $usuarioId = auth()->user()->id_usuario;

    $tusEnsambles = Ensamble::with('componentes')
        ->where('id_usuario_creador', $usuarioId)
        ->get();

    $predefinidos = Ensamble::with('componentes')
        ->where('predefinido', 1)
        ->get();

    $tienda = Ensamble::with('componentes')
        ->where('predefinido', 0)
        ->where('id_usuario_creador', '<>', $usuarioId)
        ->get();

    return view('cliente.ensambles', compact('tusEnsambles', 'predefinidos', 'tienda'));
}


public function create()
    {
        $componentes = Componente::with('tipoComponente')->get(); // Traemos todos los componentes con su tipo
        return view('cliente.crearensamble', compact('componentes'));
    }
     // Guardar el ensamble
    public function store(Request $request)
    {
        // Validar que hayan componentes seleccionados
        $request->validate([
            'componentes' => 'required|array|min:6', // mínimo 6 componentes (1 de cada tipo obligatorio)
        ]);

        // Crear ensamble asociado al cliente
        $ensamble = Ensamble::create([
            'predefinido' => false, // cliente personalizado
            'id_usuario_creador' => Auth::id(),
        ]);

        // Asociar componentes al ensamble
        $ensamble->componentes()->attach($request->componentes);

        return redirect()->route('cliente.ensambles.index')
            ->with('success', 'Ensamble creado correctamente!');
    }

}
