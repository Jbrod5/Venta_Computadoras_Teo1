<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Ensamble;
use App\Models\Componente;

class EnsambleController extends Controller
{
    public function index() {
    $ensambles = Ensamble::with('usuarioCreador', 'componentes')->get();
    return view('admin.ensambles.index', compact('ensambles'));
}

public function create() {
    $componentes = Componente::all(); // Mostrar todos los componentes disponibles
    return view('admin.ensambles.create', compact('componentes'));
}

public function store(Request $request) {
    // Obtener los componentes seleccionados
    $componentesSeleccionados = Componente::whereIn('id_componente', $request->componentes)->get();

    // Validar que contenga los tipos obligatorios
    $tiposObligatorios = ['Procesador', 'Memoria RAM', 'Almacenamiento', 'Fuente de poder', 'Gabinete', 'Motherboard'];
    $tiposPresentes = $componentesSeleccionados->pluck('tipoComponente.tipo_componente')->unique()->toArray();

    $faltantes = array_diff($tiposObligatorios, $tiposPresentes);
    if(count($faltantes) > 0){
        return back()->withInput()->withErrors(['componentes' => 'Faltan componentes obligatorios: '.implode(', ', $faltantes)]);
    }

    // Crear ensamble por defecto (ya que lo hace el admin)
    $ensamble = Ensamble::create([
        'predefinido' => true,
        'id_usuario_creador' => auth()->id(),
    ]);

    $ensamble->componentes()->attach($request->componentes);

    return redirect()->route('ensambles.index')->with('success', 'Ensamble creado correctamente');
}



    public function show($id)
    {
        $ensamble = Ensamble::with('usuarioCreador', 'componentes.tipoComponente')->findOrFail($id);

        // Calcular precio total del ensamble
        $precioTotal = $ensamble->componentes->sum('precio');

        // Validar stock: true si todos los componentes tienen al menos 1 en stock
        $puedeEnsamblar = $ensamble->componentes->every(fn($c) => $c->cantidad_stock > 0);

        return view('admin.ensambles.show', compact('ensamble', 'precioTotal', 'puedeEnsamblar'));
    }



public function edit($id)
{
    // Obtener el ensamble
    $ensamble = Ensamble::with('componentes')->findOrFail($id);

    // Obtener todos los componentes para mostrar en el select
    $componentes = Componente::with('tipoComponente')->get();

    return view('admin.ensambles.edit', compact('ensamble', 'componentes'));
}

public function update(Request $request, $id)
{
    // Validar que haya al menos un componente
    $request->validate([
        'componentes' => 'required|array|min:1',
    ]);

    // Buscar el ensamble
    $ensamble = Ensamble::findOrFail($id);

    // Obtener los componentes seleccionados
    $componentesSeleccionados = Componente::whereIn('id_componente', $request->componentes)->get();

    // Tipos obligatorios
    $tiposObligatorios = ['Procesador', 'Memoria RAM', 'Almacenamiento', 'Fuente de poder', 'Gabinete', 'Motherboard'];

    // Tipos presentes en los componentes seleccionados
    $tiposPresentes = $componentesSeleccionados->pluck('tipoComponente.tipo_componente')->unique()->toArray();

    // Verificar faltantes
    $faltantes = array_diff($tiposObligatorios, $tiposPresentes);
    if(count($faltantes) > 0){
        return back()->withInput()
                     ->withErrors(['componentes' => 'Faltan componentes obligatorios: '.implode(', ', $faltantes)]);
    }

    // Actualizar los componentes del ensamble
    $ensamble->componentes()->sync($request->componentes);

    // Guardar otros campos si aplica
    // $ensamble->nombre = $request->nombre;
    // $ensamble->save();

    return redirect()->route('ensambles.show', $ensamble->id_ensamble)
                     ->with('success', 'Ensamble actualizado correctamente');
}


public function destroy($id)
{
    $ensamble = Ensamble::findOrFail($id);
    $ensamble->delete();

    return redirect()->route('admin.ensambles.index')->with('success', 'Ensamble eliminado correctamente.');
}






}
