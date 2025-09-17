@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1>Registrar Movimiento para: {{ $componente->nombre }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inventario.registrarMovimiento', $componente->id_componente) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_tipo_movimiento" class="form-label">Tipo de Movimiento</label>
            <select class="form-select" name="id_tipo_movimiento" id="id_tipo_movimiento" required>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo_movimiento }}">{{ $tipo->tipo_movimiento }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" name="cantidad" id="cantidad" required min="1">
        </div>

        <div class="mb-3">
            <label for="observacion" class="form-label">Observación (opcional)</label>
            <textarea class="form-control" name="observacion" id="observacion"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Movimiento</button>
    </form>
</div>
@endsection
