@extends('adminlte::page')

@section('title', 'Rutas Eliminadas')

@section('content_header')
    <h1>Rutas Eliminadas Lógicamente</h1>
    <a href="{{ route('routes.index') }}" class="btn btn-secondary btn-sm mb-2">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($routes as $route)
                        <tr>
                            <td>{{ $route->id }}</td>
                            <td>{{ $route->name }}</td>
                            <td>{{ $route->origin }}</td>
                            <td>{{ $route->destination }}</td>
                            <td>
                                <form action="{{ route('routes.forceDelete', $route->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Eliminar definitivamente esta ruta?')">
                                        <i class="fas fa-trash"></i> Eliminar Real
                                    </button>
                                </form>
                                <form action="{{ route('routes.restore', $route->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-xs btn-success">
                                        <i class="fas fa-undo"></i> Restaurar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $routes->links() !!}
        </div>
    </div>
@endsection