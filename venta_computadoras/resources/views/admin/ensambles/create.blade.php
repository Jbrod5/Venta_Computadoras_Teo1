@extends('layouts.admin')

@section('content')
<div class="container mt-4">
<br>
    <h2>Crear ensamble</h2>
    <br>
    

    <form id="ensambleForm" action="{{ route('ensambles.store') }}" method="POST">
        @csrf

        @php
            // Agrupar componentes por tipo dinámicamente
            $componentesPorTipo = $componentes->groupBy(function($c) {
                return $c->tipoComponente->tipo_componente ?? 'Sin tipo';
            });
        @endphp

        @foreach($componentesPorTipo as $tipo => $componentesDelTipo)
            <h4 class="mt-4">{{ $tipo }}</h4>
            <div class="row g-3">
                @foreach($componentesDelTipo as $componente)
                <div class="col-md-3">
                    <div class="card p-2 h-100 componente-card" onclick="toggleCheckbox({{ $componente->id_componente }})">
                        <div class="form-check">
                            <input class="form-check-input me-2" type="checkbox" 
                                   name="componentes[]" 
                                   id="componente-{{ $componente->id_componente }}" 
                                   value="{{ $componente->id_componente }}"
                                   data-tipo="{{ $componente->tipoComponente->tipo_componente ?? '' }}">
                            <label class="form-check-label" for="componente-{{ $componente->id_componente }}">
                                <strong>{{ $componente->nombre }}</strong><br>
                                <span>Stock: {{ $componente->cantidad_stock }}</span>
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endforeach

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Crear Ensamble</button>
            <a href="{{ route('ensambles.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
    <br>
    <br>
    <br>
    <br>
    <p class="text-center">:3</p>
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
