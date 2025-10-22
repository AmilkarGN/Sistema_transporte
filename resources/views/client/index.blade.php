{{-- filepath: resources/views/client/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <x-adminlte-card title="Listado de Clientes" theme="primary" icon="fas fa-users">
                @if ($message = Session::get('success'))
                    <x-adminlte-alert theme="success" title="¡Éxito!">
                        {{ $message }}
                    </x-adminlte-alert>
                @endif
                
                <div class="mb-3 d-flex flex-wrap align-items-center gap-2">
    <form method="GET" action="{{ route('clients.index') }}" class="d-flex align-items-center" style="max-width: 300px;">
        <input 
            type="text" 
            name="search" 
            class="form-control form-control-sm me-2" 
            placeholder="Buscar clientes..." 
            value="{{ request('search') }}"
        >
        <button class="btn btn-secondary btn-sm" type="submit">
            <i class="fa fa-search"></i> Buscar
        </button>
    </form>
    <div class="ms-auto d-flex gap-2">
        
        @can('crear clientes') 
        <a href="{{ route('clients.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Nuevo Cliente
        </a>  
        @endcan

        @can('eliminados clientes')
        <a href="{{ route('clients.trashed') }}" class="btn btn-warning btn-sm">
            <i class="fas fa-trash-restore"></i> Ver eliminados
        </a>
        @endcan

        @can('reportes clientes')
        <a href="{{ route('clients.report', ['search' => request('search')]) }}" class="btn btn-danger btn-sm">
            <i class="fa fa-fw fa-file-pdf"></i> Generar Reporte
        </a>
        @endcan

    </div>
</div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ ($clients->currentPage() - 1) * $clients->perPage() + $loop->iteration }}</td>
                                    <td>{{ $client->nombre }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->telefono }}</td>
                                    <td>{{ $client->direccion }}</td>
                                    <td>

                                        @can('ver clientes') 
                                        <a class="btn btn-xs btn-info" href="{{ route('clients.show', $client->id) }}">
                                            <i class="fas fa-eye"></i></i> {{ __('Ver') }}
                                        </a>
                                        @endcan

                                        @can('editar clientes') 
                                        <a class="btn btn-xs btn-warning" href="{{ route('clients.edit', $client->id) }}">
                                            <i class="fas fa-edit"></i> {{ __('Editar') }}
                                        </a>
                                        @endcan

                                        <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        
                                            @can('eliminar clientes') 
                                            <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este cliente?')">
                                                <i class="fas fa-trash"></i></i> {{ __('Eliminar') }}
                                            </button>
                                            @endcan
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div>
                    {!! $clients->withQueryString()->links() !!}
                </div>
            </x-adminlte-card>
        </div>
    </div>
</div>
@stop