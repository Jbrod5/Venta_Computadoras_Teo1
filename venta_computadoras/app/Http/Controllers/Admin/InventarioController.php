<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TipoMovimientoInventario;
use App\Models\Componente;
use App\Models\MovimientoInventario;
use Illuminate\Support\Facades\Auth;

// Importar los modelos
use App\Models\TipoComponente;


class InventarioController extends Controller
{
    public function index()
    {
        // Traer todos los tipos con sus componentes
        $tipos = TipoComponente::with('componentes')->get();

        return view('admin.inventario.componentes', compact('tipos'));
    }

    public function create()
    {
        $tipos = TipoComponente::all();
        return view('admin.inventario.create_componente', compact('tipos'));
    }

    public function store(Request $request)
    {
        // Validar datos
        $validated = $request->validate([
            'id_tipo_componente' => 'required|exists:tipo_componente,id_tipo_componente',
            'nombre'            => 'required|string|max:100',
            'descripcion'       => 'nullable|string|max:200',
            'capacidad'         => 'nullable|integer|min:0',
            'marca'             => 'nullable|string|max:100',
            'modelo'            => 'nullable|string|max:100',
            'precio'            => 'required|numeric|min:0',
            'cantidad_stock'    => 'required|integer|min:0',
        ]);

        // Crear el componente
        \App\Models\Componente::create($validated);

        // Redirigir con mensaje
        return redirect()->route('inventario.index')
                         ->with('success', 'Componente agregado correctamente.');
    }


    public function edit($id)
    {
        $componente = Componente::findOrFail($id);
        $tipos = TipoComponente::all(); // para el select de tipo de componente
        return view('admin.inventario.edit_componente', compact('componente', 'tipos'));
    }

    public function update(Request $request, $id)
    {
        $componente = Componente::findOrFail($id);

        $componente->update([
            'id_tipo_componente' => $request->id_tipo_componente,
            'nombre'            => $request->nombre,
            'descripcion'       => $request->descripcion,
            'capacidad'         => $request->capacidad,
            'marca'             => $request->marca,
            'modelo'            => $request->modelo,
            'precio'            => $request->precio,
            'cantidad_stock'    => $request->cantidad_stock,
        ]);

        return redirect()->route('inventario.index')->with('success', 'Componente actualizado correctamente.');
    }





    public function movimiento($id)
{
    $componente = Componente::findOrFail($id);
    $tipos = TipoMovimientoInventario::all();

    return view('admin.inventario.movimiento', compact('componente', 'tipos'));
}

public function registrarMovimiento(Request $request, $id)
{
    $request->validate([
        'id_tipo_movimiento' => 'required|exists:tipo_movimiento_inventario,id_tipo_movimiento',
        'cantidad' => 'required|integer|min:1',
        'observacion' => 'nullable|string|max:255',
    ]);

    $componente = Componente::findOrFail($id);
    $tipoMovimiento = TipoMovimientoInventario::findOrFail($request->id_tipo_movimiento);

    // Ajustar stock según el tipo de movimiento
    if (strtolower($tipoMovimiento->tipo_movimiento) == 'entrada') {
        $componente->cantidad_stock += $request->cantidad;
    } elseif (strtolower($tipoMovimiento->tipo_movimiento) == 'salida') {
        if ($componente->cantidad_stock < $request->cantidad) {
            return back()->withErrors(['cantidad' => 'No hay suficiente stock para esta salida.']);
        }
        $componente->cantidad_stock -= $request->cantidad;
    }
    $componente->save();

    // Guardar el movimiento
    MovimientoInventario::create([
        'id_componente' => $componente->id_componente,
        'id_tipo_movimiento' => $request->id_tipo_movimiento,
        'cantidad' => $request->cantidad,
        'id_usuario' => Auth::id(),
        'observacion' => $request->observacion,
    ]);

    return redirect()->route('inventario.index')->with('success', 'Movimiento registrado correctamente!');


}


//public function getMovimientos()
//{
//    // Traer todos los tipos con sus componentes
//    $tipos = TipoComponente::with('componentes')->get();
//
//    // Traer todos los movimientos de inventario, con relaciones
//    $movimientos = MovimientoInventario::with('componente', 'tipoMovimiento', 'usuario')
//                        ->orderBy('fecha', 'desc')
//                        ->get();
//
//    return view('admin.inventario.componentes', compact('tipos', 'movimientos'));
//}

public function dashboard()
{
    $movimientos = MovimientoInventario::with('componente', 'tipoMovimiento', 'usuario')
                        ->orderBy('fecha', 'desc')
                        ->get();

    return view('admin.dashboard', compact('movimientos'));
}



}
