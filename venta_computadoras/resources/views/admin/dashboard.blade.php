@extends('layouts.admin')

@section('content')
<div class="container">

    <h2 class="mt-4">Dashboard</h2>

    {{-- Movimientos de Inventario --}}
    <h3 class="mt-4">Movimientos de Inventario</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Componente</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Observación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $mov)
            <tr>
                <td>{{ $mov->componente->nombre }}</td>
                <td>{{ $mov->tipoMovimiento->tipo_movimiento }}</td>
                <td>{{ $mov->cantidad }}</td>
                <td>{{ $mov->usuario ? $mov->usuario->nombre : 'Sistema' }}</td>
                <td>{{ $mov->fecha }}</td>
                <td>{{ $mov->observacion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Ventas --}}
    <h3 class="mt-4">Ventas Recientes</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Cliente</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Ensamblador</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->id_venta }}</td>
                <td>{{ $venta->nombre_cliente }}</td>
                <td>{{ $venta->monto }}</td>
                <td>{{ $venta->fecha }}</td>
                <td>{{ $venta->usuarioEnsamblador ? $venta->usuarioEnsamblador->nombre : 'Sistema' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Pedidos Pendientes --}}
<h3 class="mt-4">Pedidos Pendientes</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID Pedido</th>
            <th>Cliente</th>
            <th>Estado</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $pedido)
        <tr>
            <td>{{ $pedido->id_pedido }}</td>
            <td>{{ optional($pedido->usuarioPedido)->nombre ?? 'Desconocido' }}</td>
            <td>{{ optional($pedido->estadoPedido)->estado_pedido ?? 'Desconocido' }}</td>
            <td>{{ $pedido->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>


</div>
@endsection
