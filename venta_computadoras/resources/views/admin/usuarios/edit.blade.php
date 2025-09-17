@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('content')
<h1>Editar Usuario</h1>

<form action="{{ route('usuarios.update', $usuario) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" value="{{ $usuario->nombre }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Correo</label>
        <input type="email" name="correo" value="{{ $usuario->correo }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Nueva Contraseña (opcional)</label>
        <input type="text" name="pass" class="form-control">
    </div>

    <div class="mb-3">
        <label>Dirección</label>
        <input type="text" name="direccion" value="{{ $usuario->direccion }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Teléfono</label>
        <input type="number" name="telefono" value="{{ $usuario->telefono }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Rol</label>
        <select name="id_tipo_usuario" class="form-control" required>
            @foreach($roles as $r)
                <option value="{{ $r->id_tipo_usuario }}" @if($usuario->id_tipo_usuario == $r->id_tipo_usuario) selected @endif>
                    {{ $r->tipo_usuario }}
                </option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success">Actualizar</button>


    <a class="btn btn-danger {{ request()->routeIs('usuarios.*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">Cancelar</a>

</form>

<a></a>
@endsection
