@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Ensambles</h2>
    <a href="{{ route('ensambles.create') }}" class="btn btn-success mb-4">Crear Ensamble</a>

    {{-- Ensambles Predefinidos --}}
    <h4 class="mt-4">Ensamble Predefinidos</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Creador</th>
                    <th>Componentes</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ensambles->where('predefinido', true) as $ensamble)
                    <tr>
                        <td>{{ $ensamble->id_ensamble }}</td>
                        <td>Predefinido</td>
                        <td>{{ $ensamble->usuarioCreador->nombre }}</td>
                        <td>
                            @foreach($ensamble->componentes as $componente)
                                <span class="badge bg-secondary mb-1">{{ $componente->nombre }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('ensambles.show', $ensamble->id_ensamble) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('ensambles.edit', $ensamble->id_ensamble) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('ensambles.destroy', $ensamble->id_ensamble) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este ensamble?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Ensambles Personalizados --}}
    <h4 class="mt-5">Ensamble Personalizados</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-success">
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Creador</th>
                    <th>Componentes</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ensambles->where('predefinido', false) as $ensamble)
                    <tr>
                        <td>{{ $ensamble->id_ensamble }}</td>
                        <td>Personalizado</td>
                        <td>{{ $ensamble->usuarioCreador->nombre }}</td>
                        <td>
                            @foreach($ensamble->componentes as $componente)
                                <span class="badge bg-secondary mb-1">{{ $componente->nombre }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('ensambles.show', $ensamble->id_ensamble) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('ensambles.edit', $ensamble->id_ensamble) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('ensambles.destroy', $ensamble->id_ensamble) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar este ensamble?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
