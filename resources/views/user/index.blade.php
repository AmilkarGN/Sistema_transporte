@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
<div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
        <form method="GET" action="{{ route('users.index') }}" class="d-flex align-items-center" style="max-width:400px;">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Buscar por conductor o vehículo..." value="{{ request('search') }}">
            <button class="btn btn-secondary btn-sm" type="submit"><i class="fa fa-search"></i> Buscar</button>
        </form>
        
        <div class="ms-auto d-flex gap-2">

            

            @can('crear usuarios')  
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nueva Usuario
            </a>
            @endcan

            @can('eliminados')
            <a href="{{ route('users.deleted') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-trash-restore"></i> Ver eliminados
            </a>
            @endcan

            @can('generar reporte')  
            <a href="{{ route('users.report', ['search' => request('search')]) }}" class="btn btn-danger btn-sm">
                <i class="fa fa-file-pdf"></i> Generar Reporte
            </a>
            @endcan

        </div>
</div>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $user)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $user->name ?? '-' }}</td>
                            <td>{{ $user->email ?? '-' }}</td>
                            <td>{{ $user->phone ?? '-' }}</td>
                            <td>{{ $user->address ?? '-' }}</td>
                            <td>
                                {{ $user->roles->pluck('name')->join(', ') ?: '-' }}
                            </td>
                            <td>
                                @can('ver usuario')
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">Ver</a>
                                @endcan

                                @can('editar usuario')    
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                @endcan

                                @can('eliminar')
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro de eliminar?')">Eliminar</button>
                                </form>
                                @endcan

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                {{ $users->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Aquí puedes agregar CSS personalizado si lo necesitas --}}
@endsection

@section('js')
    {{-- Aquí puedes agregar JS personalizado si lo necesitas --}}
@endsection