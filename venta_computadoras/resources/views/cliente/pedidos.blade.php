@extends('layouts.cliente')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Mis Pedidos</h2>

    @if($pedidos->count() > 0)
        <div class="accordion" id="pedidosAccordion">
            @foreach($pedidos as $pedido)
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="heading{{ $pedido->id_pedido }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $pedido->id_pedido }}" aria-expanded="false" aria-controls="collapse{{ $pedido->id_pedido }}">
                            Pedido #{{ $pedido->id_pedido }} - Estado: {{ $pedido->estado->estado_pedido ?? 'Desconocido' }}
                        </button>
                    </h2>
                    <div id="collapse{{ $pedido->id_pedido }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $pedido->id_pedido }}" data-bs-parent="#pedidosAccordion">
                        <div class="accordion-body">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Nombre</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pedido->detalles as $detalle)
                                        @if($detalle->id_componente)
                                            <tr>
                                                <td>Componente</td>
                                                <td>{{ $detalle->componente->nombre }}</td>
                                                <td>{{ $detalle->cantidad }}</td>
                                                <td>Q{{ number_format($detalle->componente->precio, 2) }}</td>
                                                <td>Q{{ number_format($detalle->componente->precio * $detalle->cantidad, 2) }}</td>
                                            </tr>
                                        @elseif($detalle->id_ensamble)
                                            <tr>
                                                <td colspan="5"><strong>Ensamble #{{ $detalle->ensamble->id_ensamble }}:</strong></td>
                                            </tr>
                                            @foreach($detalle->ensamble->componentes as $comp)
                                                <tr>
                                                    <td>Componente</td>
                                                    <td>{{ $comp->nombre }}</td>
                                                    <td>{{ $detalle->cantidad }}</td>
                                                    <td>Q{{ number_format($comp->precio, 2) }}</td>
                                                    <td>Q{{ number_format($comp->precio * $detalle->cantidad, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>

                            @php
                                $total = 0;
                                foreach($pedido->detalles as $d) {
                                    if($d->id_componente) {
                                        $total += $d->componente->precio * $d->cantidad;
                                    } elseif($d->id_ensamble) {
                                        foreach($d->ensamble->componentes as $comp) {
                                            $total += $comp->precio * $d->cantidad;
                                        }
                                    }
                                }
                            @endphp
                            <h5 class="text-end">Total: Q{{ number_format($total, 2) }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">No tienes pedidos aún.</div>
    @endif
</div>
@endsection
