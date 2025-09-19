@extends('layouts.cliente')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Ensambles</h1>
        <a href="{{ route('cliente.ensambles.create') }}" class="btn btn-primary">Crear nuevo ensamble</a>
    </div>

    @php
        $sectionStyles = [
            'tus' => 'border-left:4px solid #0d6efd; padding-left:10px;',
            'predefinidos' => 'border-left:4px solid #0dcaf0; padding-left:10px;',
            'tienda' => 'border-left:4px solid #ffc107; padding-left:10px;'
        ];
    @endphp

    <!-- Tus ensambles -->
    <h3 style="{{ $sectionStyles['tus'] }}">Tus ensambles</h3>
    <div class="row mb-4">
        @forelse($tusEnsambles as $ensamble)
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-dark fs-5 mb-3">{{ $ensamble->nombre ?? 'Ensamble #' . $ensamble->id_ensamble }}</h5>
                        <div class="list-group list-group-flush mb-3">
                            @foreach($ensamble->componentes as $comp)
                                <div class="list-group-item px-0 py-2 border-bottom text-secondary">
                                    <div><strong>{{ $comp->tipoComponente->tipo_componente ?? 'Componente' }}:</strong> {{ $comp->nombre }}</div>
                                    <div><strong>Marca:</strong> {{ $comp->marca }}</div>
                                    <div><strong>Modelo:</strong> {{ $comp->modelo }}</div>
                                    @if($comp->capacidad)
                                        <div><strong>Capacidad:</strong> {{ $comp->capacidad }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <form action="{{ route('carrito.agregar.ensamble', $ensamble->id_ensamble) }}" method="POST">
                            @csrf
                            <button class="btn btn-success w-100">Agregar al carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>No tienes ensambles aún.</p>
        @endforelse
    </div>

    <!-- Ensambles customizados de otros usuarios -->
    <h3 style="{{ $sectionStyles['predefinidos'] }}">Ensambles customizados de otros usuarios</h3>
    <div class="row mb-4">
        @forelse($predefinidos as $ensamble)
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-dark fs-5 mb-3">Ensamble #{{ $ensamble->id_ensamble }}</h5>
                        <div class="list-group list-group-flush mb-3">
                            @foreach($ensamble->componentes as $comp)
                                <div class="list-group-item px-0 py-2 border-bottom text-secondary">
                                    <div><strong>{{ $comp->tipoComponente->tipo_componente ?? 'Componente' }}:</strong> {{ $comp->nombre }}</div>
                                    <div><strong>Marca:</strong> {{ $comp->marca }}</div>
                                    <div><strong>Modelo:</strong> {{ $comp->modelo }}</div>
                                    @if($comp->capacidad)
                                        <div><strong>Capacidad:</strong> {{ $comp->capacidad }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <form action="{{ route('carrito.agregar.ensamble', $ensamble->id_ensamble) }}" method="POST">
                            @csrf
                            <button class="btn btn-success w-100">Agregar al carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>No hay ensambles customizados aún.</p>
        @endforelse
    </div>

    <!-- Ensambles de la tienda -->
    <h3 style="{{ $sectionStyles['tienda'] }}">Ensambles de la tienda</h3>
    <div class="row mb-4">
        @forelse($tienda as $ensamble)
            <div class="col-md-4 mb-3">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-dark fs-5 mb-3">Ensamble #{{ $ensamble->id_ensamble }}</h5>
                        <div class="list-group list-group-flush mb-3">
                            @foreach($ensamble->componentes as $comp)
                                <div class="list-group-item px-0 py-2 border-bottom text-secondary">
                                    <div><strong>{{ $comp->tipoComponente->tipo_componente ?? 'Componente' }}:</strong> {{ $comp->nombre }}</div>
                                    <div><strong>Marca:</strong> {{ $comp->marca }}</div>
                                    <div><strong>Modelo:</strong> {{ $comp->modelo }}</div>
                                    @if($comp->capacidad)
                                        <div><strong>Capacidad:</strong> {{ $comp->capacidad }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <form action="{{ route('carrito.agregar.ensamble', $ensamble->id_ensamble) }}" method="POST">
                            @csrf
                            <button class="btn btn-success w-100">Agregar al carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p>No hay ensambles en la tienda.</p>
        @endforelse
    </div>
</div>
@endsection
