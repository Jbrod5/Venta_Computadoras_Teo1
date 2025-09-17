<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MovimientoInventario;
use App\Models\Venta;

use App\Models\Pedido;  
use App\Models\Usuario;


class AdminDashboardController extends Controller
{
    


    public function dashboard()
    {
        // Movimientos de inventario
        $movimientos = MovimientoInventario::with('componente', 'tipoMovimiento', 'usuario')
                            ->orderBy('fecha', 'desc')
                            ->get();

        // Ventas recientes
        $ventas = Venta::with('pedido', 'usuarioEnsamblador')
                            ->orderBy('fecha', 'desc')
                            ->get();

        // Pedidos pendientes
        $pedidos = Pedido::with('usuarioPedido', 'estadoPedido')
                            ->where('id_estado_pedido', 1) // Pendientes
                            ->orderBy('id_pedido', 'desc')
                            ->get();

        // Pasarlas todas a la vista
        return view('admin.dashboard', compact('movimientos', 'ventas', 'pedidos'));

    }



}
