@extends('adminlte::page')

@section('title', 'Usuarios, Conductores y Roles')

@section('content_header')
    <h1>Usuarios, Conductores y Roles</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center gap-2 mb-3">
                <form method="GET" action="{{ route('usuarios.combinados') }}" class="d-flex align-items-center gap-2 mb-0">
                    <input type="text" name="search" class="form-control" style="width:200px;" placeholder="Buscar..." value="{{ request('search') }}">
                    <button class="btn btn-secondary btn-sm" type="submit">Buscar</button>
                </form>
                <a href="{{ route('usuarios.combinados') }}" class="btn btn-secondary btn-sm">
                    Cancelar búsqueda
                </a>
                <a href="{{ route('usuarios.combinados.reporte', ['search' => request('search')]) }}" class="btn btn-danger btn-sm">
                    <i class="fa fa-fw fa-file-pdf"></i> Generar Reporte
                </a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre Usuario</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Número de Licencia</th>
                        <th>Tipo de Licencia</th>
                        <th>Estado Conductor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->role->name ?? 'Sin rol' }}</td>
                            <td>{{ $usuario->driver->license_number ?? 'No conductor' }}</td>
                            <td>{{ $usuario->driver->license_type ?? '-' }}</td>
                            <td>{{ $usuario->driver->status ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection