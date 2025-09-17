@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Editar Componente</h1>

    <form action="{{ route('inventario.update', $componente->id_componente) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id_tipo_componente" class="form-label">Tipo de Componente:</label>
            <select name="id_tipo_componente" id="id_tipo_componente" class="form-select">
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id_tipo_componente }}" 
                        {{ $componente->id_tipo_componente == $tipo->id_tipo_componente ? 'selected' : '' }}>
                        {{ $tipo->tipo_componente }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $componente->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3">{{ $componente->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad:</label>
            <input type="number" name="capacidad" id="capacidad" class="form-control" value="{{ $componente->capacidad }}">
        </div>

        <div class="mb-3">
            <label for="marca" class="form-label">Marca:</label>
            <input type="text" name="marca" id="marca" class="form-control" value="{{ $componente->marca }}">
        </div>

        <div class="mb-3">
            <label for="modelo" class="form-label">Modelo:</label>
            <input type="text" name="modelo" id="modelo" class="form-control" value="{{ $componente->modelo }}">
        </div>

        <div class="mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="{{ $componente->precio }}" required>
        </div>

        <div class="mb-3">
            <label for="cantidad_stock" class="form-label">Cantidad en Stock:</label>
            <input type="number" name="cantidad_stock" id="cantidad_stock" class="form-control" value="{{ $componente->cantidad_stock }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Componente</button>
        <a href="{{ route('inventario.index') }}" class="btn btn-secondary ms-2">Cancelar</a>
    </form>
</div>
@endsection
