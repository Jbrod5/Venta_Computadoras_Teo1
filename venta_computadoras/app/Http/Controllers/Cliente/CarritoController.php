<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;


use App\Models\Componente;
use App\Models\Ensamble;
use App\Models\TipoComponente;
use App\Models\EstadoPedido;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\HistorialCambiosPedido;
use App\Models\Venta;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



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
            'id' => $componente->id_componente,
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
    $ensamble = Ensamble::with('componentes')->findOrFail($id);

    $carrito = session()->get('carrito', []);
    if(isset($carrito['ensamble'][$id])) {
        $carrito['ensamble'][$id]['cantidad']++;
    } else {
        // Calcula el monto sumando componentes
        $precioTotal = 0;
        $componentes = [];
        foreach ($ensamble->componentes as $comp) {
            $precioTotal += $comp->precio;
            $componentes[] = [
                'id' => $comp->id_componente,
                'nombre' => $comp->nombre,
                'precio' => $comp->precio,
            ];
        }

        $carrito['ensamble'][$id] = [
            'id' => $ensamble->id_ensamble,
            'nombre' => 'Ensamble #' . $ensamble->id_ensamble,
            'precio' => $precioTotal, // <- ahora calculado dinámicamente
            'cantidad' => 1,
            'componentes' => $componentes // <- guardamos los detalles
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


public function confirmarCompra(Request $request)
{
    $carrito = session()->get('carrito', []);

    if(empty($carrito['componente']) && empty($carrito['ensamble'])) {
        return redirect()->back()->with('error', 'El carrito está vacío.');
    }

    DB::transaction(function() use ($carrito) {

        $pedido = Pedido::create([
            'id_usuario_pedido' => Auth::id(), 
            'id_estado_pedido' => EstadoPedido::where('estado_pedido', 'Pendiente')->first()->id_estado_pedido,
        ]);

        // --- Componentes individuales ---
        foreach($carrito['componente'] ?? [] as $item) {
            PedidoDetalle::create([
                'id_pedido' => $pedido->id_pedido,
                'id_componente' => $item['id'], // <- ahora sí seguro
                'cantidad' => $item['cantidad'],
                'id_ensamble' => null,
            ]);
        
            $componente = Componente::find($item['id']);
            if($componente) {
                $componente->cantidad_stock -= $item['cantidad'];
                $componente->save();
            }
        }


        // --- Ensambles ---
        foreach($carrito['ensamble'] ?? [] as $item) {
            PedidoDetalle::create([
                'id_pedido' => $pedido->id_pedido,
                'id_ensamble' => $item['id'], // <- ahora sí seguro
                'cantidad' => $item['cantidad'],
                'id_componente' => null,
            ]);
        
            $ensamble = Ensamble::find($item['id']);
            if($ensamble) {
                foreach($ensamble->componentes as $comp) {
                    $comp->cantidad_stock -= $item['cantidad'];
                    $comp->save();
                }
            }
        }


        // Historial de cambios
        HistorialCambiosPedido::create([
            'id_pedido' => $pedido->id_pedido,
            'id_estado_pedido' => $pedido->id_estado_pedido,
        ]);

        // Crear venta
        $total = 0;
        foreach($carrito['componente'] ?? [] as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        foreach($carrito['ensamble'] ?? [] as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }

        Venta::create([
            'id_pedido' => $pedido->id_pedido,
            'fecha' => now(),
            'nombre_cliente' => Auth::user()->nombre,
            'id_usuario_ensamblador' => Auth::id(),
            'monto' => $total,
        ]);
    });

    session()->forget('carrito');

    return redirect()->route('carrito.index')->with('success', 'Compra solicitada exitosamente. Su pedido se encuentra pendiente.');
}


}
