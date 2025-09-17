@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1>Inventario de Componentes</h1>
    <a href="{{ route('inventario.create') }}" class="btn btn-success mb-3">Agregar Componente</a>

    @foreach($tipos as $tipo)
        <h3>{{ $tipo->tipo_componente }}</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Capacidad</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Precio</th>
                    <th>Cantidad en stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tipo->componentes as $c)
                    <tr>
                        <td>{{ $c->nombre }}</td>
                        <td>{{ $c->descripcion }}</td>
                        <td>{{ $c->capacidad }}</td>
                        <td>{{ $c->marca }}</td>
                        <td>{{ $c->modelo }}</td>
                        <td>{{ $c->precio }}</td>
                        <td @if($c->cantidad_stock < 10) style="color:red;font-weight:bold" @endif>
                            {{ $c->cantidad_stock }}
                        </td>
                        <td>
                            <a href="{{ route('inventario.edit', $c->id_componente) }}" class="btn btn-primary btn-sm">Editar</a>
                            <a href="{{ route('inventario.movimiento', $c->id_componente) }}" class="btn btn-warning btn-sm">Movimiento</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <br>
        <br>
        <br>
    @endforeach
</div>
@endsection
