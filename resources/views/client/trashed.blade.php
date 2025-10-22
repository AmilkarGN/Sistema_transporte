@extends('adminlte::page')

@section('title', 'Clientes Eliminados')

@section('content_header')
    <h1>Clientes Eliminados</h1>
@stop

@section('content')
    <x-adminlte-card title="Clientes Eliminados" theme="danger" icon="fas fa-trash">
        <a href="{{ route('clients.index') }}" class="btn btn-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
        @if ($message = Session::get('success'))
            <x-adminlte-alert theme="success" title="¡Éxito!">
                {{ $message }}
            </x-adminlte-alert>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->id }}</td>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->phone }}</td>
                            <td>
                                <form action="{{ route('clients.force-delete', $client->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Eliminar definitivamente este cliente?')">
                                        <i class="fas fa-trash"></i> Eliminar Real
                                    </button>
                                </form>
                                <form action="{{ route('clients.restore', $client->id) }}" method="POST" style="display:inline;">
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
        </div>
        <div>
            {!! $clients->links() !!}
        </div>
    </x-adminlte-card>
@stop