<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;

use Illuminate\Support\Facades\Auth;


class PedidosController extends Controller
{
public function index()
{
    $pedidos = Pedido::with([
        'estado',
        'detalles.componente',
        'detalles.ensamble.componentes.tipoComponente'
    ])
    ->where('id_usuario_pedido', Auth::id())
    ->orderBy('id_pedido', 'desc')
    ->get();

    return view('cliente.pedidos', compact('pedidos'));
}

}