@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Detalle del Ensamble #{{ $ensamble->id_ensamble }}</h2>

    <div class="mb-3">
        <strong>Tipo:</strong> {{ $ensamble->predefinido ? 'Predefinido' : 'Personalizado' }}
    </div>

    <div class="mb-3">
        <strong>Creador:</strong> {{ $ensamble->usuarioCreador->nombre }}
    </div>

    <div class="mb-3">
        <strong>Componentes:</strong>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Capacidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ensamble->componentes as $componente)
                <tr>
                    <td>{{ $componente->nombre }}</td>
                    <td>{{ $componente->tipoComponente->tipo_componente }}</td>
                    <td>{{ $componente->marca }}</td>
                    <td>{{ $componente->modelo }}</td>
                    <td>{{ $componente->capacidad }}</td>
                    <td>${{ number_format($componente->precio, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mb-3">
    <strong>Precio Total:</strong> ${{ number_format($precioTotal, 2) }}
</div>

<div class="mb-3">
    @if($puedeEnsamblar)
        <span class="badge bg-success">Todos los componentes disponibles ✅</span>
    @else
        <span class="badge bg-danger">¡Faltan componentes! ⚠️</span>


         <div class="alert alert-warning">
        <strong>Componentes faltantes:</strong>
        <ul>
            @foreach($ensamble->componentes as $componente)
                @if($componente->cantidad_stock <= 0)
                    <li>{{ $componente->nombre }} ({{ $componente->tipoComponente->tipo_componente }})</li>
                @endif
            @endforeach
        </ul>
    </div>
    @endif
</div>

    <a href="{{ route('ensambles.index') }}" class="btn btn-secondary">Volver a la lista</a>
</div>
@endsection
