<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
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
    </form>
</div>
</body>
</html>
