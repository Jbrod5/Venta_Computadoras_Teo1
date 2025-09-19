<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;


use App\Models\Componente;
use App\Models\Ensamble;
use App\Models\TipoComponente;
use App\Models\Pedido;


use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = session()->get('carrito', []);
        return view('cliente.carrito', compact('carrito'));
    }

    public function agregarComponente($id)
{
    $componente = Componente::findOrFail($id);

    $carrito = session()->get('carrito', []);
    if(isset($carrito['componente'][$id])) {
        $carrito['componente'][$id]['cantidad']++;
    } else {
        $carrito['componente'][$id] = [
            'nombre' => $componente->nombre,
            'precio' => $componente->precio,
            'cantidad' => 1
        ];
    }
    session()->put('carrito', $carrito);

    return redirect()->back()->with('success', 'Componente agregado al carrito!');
}

public function agregarEnsamble($id)
{
    $ensamble = Ensamble::findOrFail($id);

    $carrito = session()->get('carrito', []);
    if(isset($carrito['ensamble'][$id])) {
        $carrito['ensamble'][$id]['cantidad']++;
    } else {
        $carrito['ensamble'][$id] = [
            'nombre' => 'Ensamble #' . $ensamble->id_ensamble, // O cualquier info que quieras
            'precio' => $ensamble->monto ?? 0, // si tienes precio
            'cantidad' => 1
        ];
    }
    session()->put('carrito', $carrito);

    return redirect()->back()->with('success', 'Ensamble agregado al carrito!');
}


// Actualizar cantidad de componente
public function actualizarComponente(Request $request, $id)
{
    $cantidad = max(1, (int) $request->cantidad); // al menos 1

    $carrito = session()->get('carrito', []);
    if(isset($carrito['componente'][$id])) {
        $carrito['componente'][$id]['cantidad'] = $cantidad;
        session()->put('carrito', $carrito);
        return redirect()->back()->with('success', 'Cantidad actualizada.');
    }
    return redirect()->back()->with('error', 'Componente no encontrado en el carrito.');
}

// Eliminar componente
public function eliminarComponente($id)
{
    $carrito = session()->get('carrito', []);
    if(isset($carrito['componente'][$id])) {
        unset($carrito['componente'][$id]);
        session()->put('carrito', $carrito);
        return redirect()->back()->with('success', 'Componente eliminado.');
    }
    return redirect()->back()->with('error', 'Componente no encontrado en el carrito.');
}

// Actualizar cantidad de ensamble
public function actualizarEnsamble(Request $request, $id)
{
    $cantidad = max(1, (int) $request->cantidad);

    $carrito = session()->get('carrito', []);
    if(isset($carrito['ensamble'][$id])) {
        $carrito['ensamble'][$id]['cantidad'] = $cantidad;
        session()->put('carrito', $carrito);
        return redirect()->back()->with('success', 'Cantidad actualizada.');
    }
    return redirect()->back()->with('error', 'Ensamble no encontrado en el carrito.');
}

// Eliminar ensamble
public function eliminarEnsamble($id)
{
    $carrito = session()->get('carrito', []);
    if(isset($carrito['ensamble'][$id])) {
        unset($carrito['ensamble'][$id]);
        session()->put('carrito', $carrito);
        return redirect()->back()->with('success', 'Ensamble eliminado.');
    }
    return redirect()->back()->with('error', 'Ensamble no encontrado en el carrito.');
}


}
