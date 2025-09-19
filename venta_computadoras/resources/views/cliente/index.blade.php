@extends('layouts.cliente')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Catálogo de Componentes</h2>

    <!-- Filtro de tipos -->
    <div class="mb-4">
        <label for="tipoFiltro" class="form-label">Filtrar por tipo:</label>
        <select class="form-select w-auto" id="tipoFiltro">
            <option value="todos" selected>Todos</option>
            @foreach($tipos as $tipo)
                <option value="tipo-{{ $tipo->id_tipo_componente }}">{{ $tipo->tipo_componente }}</option>
            @endforeach
        </select>
    </div>

    <!-- Listado de componentes por tipo -->
    @foreach($tipos as $tipo)
        <div class="tipo-grupo tipo-{{ $tipo->id_tipo_componente }}">
            <h4 class="mt-4">{{ $tipo->tipo_componente }}</h4>
            <div class="row">
                @forelse($tipo->componentes as $componente)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $componente->nombre }}</h5>
                                <p class="card-text">
                                    <strong>Tipo:</strong> {{ $componente->tipoComponente->tipo_componente ?? 'N/A' }}<br>
                                    <strong>Marca:</strong> {{ $componente->marca ?? 'N/A' }}<br>
                                    <strong>Modelo:</strong> {{ $componente->modelo ?? 'N/A' }}<br>
                                    <strong>Capacidad:</strong> {{ $componente->capacidad ?? '-' }}<br>
                                    <strong>Precio:</strong> Q{{ number_format($componente->precio, 2) }}<br>
                                    <strong>Stock:</strong> {{ $componente->cantidad_stock }}
                                </p>
                            </div>
                            <div class="card-footer text-center">
                                @if($componente->cantidad_stock > 0)
                                    <form action="{{ route('carrito.agregar.componente', $componente->id_componente) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                                </form>
                                @else
                                    <span class="badge bg-danger">Sin stock</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="ms-3">No hay componentes en esta categoría.</p>
                @endforelse
            </div>
        </div>
    @endforeach
</div>

<!-- Script para filtrar por tipo -->
<script>
    document.getElementById('tipoFiltro').addEventListener('change', function () {
        let valor = this.value;
        let grupos = document.querySelectorAll('.tipo-grupo');

        grupos.forEach(grupo => {
            if (valor === 'todos') {
                grupo.style.display = 'block';
            } else {
                grupo.style.display = grupo.classList.contains(valor) ? 'block' : 'none';
            }
        });
    });
</script>
@endsection

