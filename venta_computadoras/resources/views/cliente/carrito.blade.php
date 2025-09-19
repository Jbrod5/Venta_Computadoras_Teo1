@extends('layouts.cliente')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Tu Carrito</h2>

    {{-- Alertas de sesión --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if(session('carrito') && (count(session('carrito')['componente'] ?? []) > 0 || count(session('carrito')['ensamble'] ?? []) > 0))
        <div class="row">
            <div class="col-12">

                {{-- Tabla de Componentes --}}
                @if(session('carrito')['componente'] ?? false)
                <h4>Componentes</h4>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('carrito')['componente'] as $id => $item)
                        <tr>
                            <td>{{ $item['nombre'] }}</td>
                            <td>Q{{ number_format($item['precio'], 2) }}</td>
                            <td>
                                <form action="{{ route('carrito.actualizar.componente', $id) }}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" class="form-control form-control-sm me-2" style="width:70px;">
                                    <button class="btn btn-sm btn-primary">Actualizar</button>
                                </form>
                            </td>
                            <td>Q{{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                            <td>
                                <form action="{{ route('carrito.eliminar.componente', $id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

                {{-- Tabla de Ensambles --}}
                @if(session('carrito')['ensamble'] ?? false)
                <h4 class="mt-4">Ensambles</h4>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre / Componentes</th>
                            <th>Precio Total Ensamble</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('carrito')['ensamble'] as $id => $item)
                        <tr>
                            <td>
                                <strong>{{ $item['nombre'] }}</strong>
                                @if(!empty($item['componentes']))
                                    <ul class="mt-2">
                                        @foreach($item['componentes'] as $comp)
                                            <li>{{ $comp['nombre'] }} - Q{{ number_format($comp['precio'], 2) }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                            <td>Q{{ number_format($item['precio'], 2) }}</td>
                            <td>
                                <form action="{{ route('carrito.actualizar.ensamble', $id) }}" method="POST" class="d-flex">
                                    @csrf
                                    <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" class="form-control form-control-sm me-2" style="width:70px;">
                                    <button class="btn btn-sm btn-primary">Actualizar</button>
                                </form>
                            </td>
                            <td>Q{{ number_format($item['precio'] * $item['cantidad'], 2) }}</td>
                            <td>
                                <form action="{{ route('carrito.eliminar.ensamble', $id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

                {{-- Total --}}
                @php
                    $total = 0;
                    foreach(session('carrito')['componente'] ?? [] as $item) {
                        $total += $item['precio'] * $item['cantidad'];
                    }
                    foreach(session('carrito')['ensamble'] ?? [] as $item) {
                        $total += $item['precio'] * $item['cantidad'];
                    }
                @endphp
                <h4 class="text-end">Total: Q{{ number_format($total, 2) }}</h4>

                <div class="text-end mt-3">
                    <form action="{{ route('carrito.confirmar') }}" method="POST">
                        @csrf
                        <button class="btn btn-success btn-lg">Confirmar Compra</button>
                    </form>
                </div>

            </div>
        </div>
    @else
        <div class="alert alert-info">
            Tu carrito está vacío.
        </div>
    @endif
</div>
@endsection
