<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MovimientoInventario;
use App\Models\TipoMovimientoInventario;
use App\Models\Componente;
use Illuminate\Support\Facades\Auth;

class MovimientoInventarioController extends Controller
{
    public function create()
    {
        $componentes = Componente::all();
        $tipos = TipoMovimientoInventario::all();

        return view('admin.movimiento', compact('componentes', 'tipos'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'id_componente' => 'required|exists:componente,id_componente',
            'id_tipo_movimiento' => 'required|exists:tipo_movimiento_inventario,id_tipo_movimiento',
            'cantidad' => 'required|integer|min:1',
            'observacion' => 'nullable|string|max:255',
        ]);

        $componente = Componente::findOrFail($request->id_componente);
        $tipo = $request->id_tipo_movimiento;

        // Verificar si es entrada o salida
        $tipoMovimiento = TipoMovimientoInventario::findOrFail($tipo);
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
            'id_componente' => $request->id_componente,
            'id_tipo_movimiento' => $request->id_tipo_movimiento,
            'cantidad' => $request->cantidad,
            'id_usuario' => Auth::id(),
            'observacion' => $request->observacion,
        ]);

        //return redirect()->back()->with('success', 'Movimiento registrado correctamente!');
        return view('admin.movimiento', compact('componentes', 'tipos'));
    }
}
