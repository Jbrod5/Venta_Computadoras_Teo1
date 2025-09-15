<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1>Crear Usuario</h1>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="correo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Contraseña</label>
            <input type="text" name="pass" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="number" name="telefono" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Rol</label>
            <select name="id_tipo_usuario" class="form-control" required>
                @foreach($roles as $r)
                    <option value="{{ $r->id_tipo_usuario }}">{{ $r->tipo_usuario }}</option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-success">Guardar</button>
    </form>
</div>
</body>
</html>
