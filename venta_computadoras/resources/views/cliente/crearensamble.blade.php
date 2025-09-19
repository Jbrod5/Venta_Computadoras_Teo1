@extends('layouts.cliente')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Crear Ensamble</h2>

    <form id="ensambleForm" action="{{ route('cliente.ensambles.store') }}" method="POST">
        @csrf

        @php
            $componentesPorTipo = $componentes->groupBy(fn($c) => $c->tipoComponente->tipo_componente ?? 'Sin tipo');
        @endphp

        @foreach($componentesPorTipo as $tipo => $componentesDelTipo)
            <!-- Título de sección en negro -->
            <h4 class="mt-4 mb-3 text-dark">{{ $tipo }}:</h4>

            <div class="row g-3">
                @foreach($componentesDelTipo as $componente)
                    <div class="col-md-3">
                        <div class="card p-3 h-100 componente-card border-1 shadow-sm" onclick="toggleCheckbox({{ $componente->id_componente }})" style="cursor: pointer;">
                            <div class="form-check">
                                <input class="form-check-input me-2" type="checkbox" 
                                       name="componentes[]" 
                                       id="componente-{{ $componente->id_componente }}" 
                                       value="{{ $componente->id_componente }}"
                                       data-tipo="{{ $componente->tipoComponente->tipo_componente ?? '' }}">
                                <label class="form-check-label" for="componente-{{ $componente->id_componente }}">
                                    <strong class="d-block text-black fs-6">{{ $componente->nombre }}</strong>
                                    <div class="text-secondary mt-1" style="font-size: 0.9rem;">
                                        Modelo: {{ $componente->modelo ?? '-' }}<br>
                                        Marca: {{ $componente->marca ?? '-' }}<br>
                                        @if($componente->capacidad)
                                            Capacidad: {{ $componente->capacidad }}
                                        @endif
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach

        <div class="mt-4">
            <button type="submit" class="btn btn-primary me-2">Crear Ensamble</button>
            <a href="{{ route('cliente.ensambles.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
function toggleCheckbox(id) {
    const checkbox = document.getElementById('componente-' + id);
    checkbox.checked = !checkbox.checked;
}

// Validación de componentes mínimos
document.getElementById('ensambleForm').addEventListener('submit', function(e){
    const checkboxes = document.querySelectorAll('input[name="componentes[]"]:checked');
    const tiposSeleccionados = Array.from(checkboxes).map(cb => cb.dataset.tipo);

    const tiposObligatorios = ['Procesador', 'Memoria RAM', 'Almacenamiento', 'Fuente de poder', 'Gabinete', 'Motherboard'];
    const faltantes = tiposObligatorios.filter(tipo => !tiposSeleccionados.includes(tipo));

    if(faltantes.length > 0){
        e.preventDefault();
        alert('Faltan componentes obligatorios: ' + faltantes.join(', '));
    }
});
</script>
@endsection
