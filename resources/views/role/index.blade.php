@extends('adminlte::page')

@section('title', 'Roles')

@section('content_header')
    <h1>{{ __('Roles') }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span id="card_title">
                    {{ __('Roles') }}
                </span>

                <!-- Formulario de búsqueda -->
                <form method="GET" action="{{ route('roles.index') }}" class="d-flex align-items-center">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control me-2" 
                        placeholder="Buscar roles..." 
                        value="{{ request('search') }}" 
                        style="max-width: 250px;"
                    >

                    <button class="btn btn-secondary btn-sm" type="submit">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                </form>

                <div class="float-right d-flex align-items-center">

                    @can('crear roles')
                    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                        Crear Nuevo
                    </a>
                    @endcan

                    <!-- Botón de reporte -->
                    @can('generar reporte') 
                    <a href="{{ route('roles.report', ['search' => request('search')]) }}" class="btn btn-danger btn-sm ms-2">
                        <i class="fa fa-fw fa-file-pdf"></i> Generar Reporte
                    </a>
                    @endcan

                    @can('ver detalles combinados')    
                    <a href="{{ route('roles.combinados') }}" class="btn btn-info btn-sm mb-2">
                        <i class="fas fa-users-cog"></i> Ver detalles combinados
                    </a>
                    @endcan

                    <!-- Botón de roles eliminados -->
                    @can('eliminados')  
                    <a href="{{ route('roles.eliminados') }}" class="btn btn-warning btn-sm ms-2">
                        <i class="fa fa-fw fa-trash"></i> Ver Roles Eliminados</a>
                    @endcan

                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success m-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead">
                        <tr>
                            <th>No</th>
                            <th>Nombre</th>
                            <th>Guardia</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->guard_name }}</td>
                                <td>
                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST">

                                        @can('ver roles')
                                        <a class="btn btn-sm btn-primary" href="{{ route('roles.show', $role->id) }}">
                                            <i class="fa fa-fw fa-eye"></i> Ver
                                        </a>
                                        @endcan

                                        @can('editar roles')
                                        <a class="btn btn-sm btn-success" href="{{ route('roles.edit', $role->id) }}">
                                            <i class="fa fa-fw fa-edit"></i> Editar
                                        </a>
                                        @endcan

                                        @can('eliminar roles')
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar?') ? this.closest('form').submit() : false;">
                                            <i class="fa fa-fw fa-trash"></i> Eliminar
                                        </button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! $roles->withQueryString()->links() !!}
@endsection

@section('css')
    {{-- Aquí puedes agregar estilos personalizados si es necesario --}}
@endsection

@section('js')
    {{-- Aquí puedes agregar scripts personalizados si es necesario --}}
@endsection