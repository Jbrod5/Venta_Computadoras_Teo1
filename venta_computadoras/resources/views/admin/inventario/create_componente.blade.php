@extends('layouts.admin') {{-- o el layout que uses --}}

@section('content')
<div class="container mt-4">
    <h2>Agregar Componente</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inventario.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_tipo_componente" class="form-label">Tipo de Componente</label>
            <select name="id_tipo_componente" id="id_tipo_componente" class="form-select" required>
                <option value="">Selecciona un tipo</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo_componente }}">{{ $tipo->tipo_componente }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <input type="number" name="capacidad" id="capacidad" class="form-control" min="0">
            <div class="form-text">GB, MHz, nucleos, vatios según corresponda</div>
        </div>

        <div class="mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" name="marca" id="marca" class="form-control">
        </div>

        <div class="mb-3">
            <label for="modelo" class="form-label">Modelo</label>
            <input type="text" name="modelo" id="modelo" class="form-control">
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" name="precio" id="precio" class="form-control" min="0" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="cantidad_stock" class="form-label">Cantidad en Stock</label>
            <input type="number" name="cantidad_stock" id="cantidad_stock" class="form-control" min="0" required>
        </div>

        <button type="submit" class="btn btn-success">Agregar Componente</button>
        <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
