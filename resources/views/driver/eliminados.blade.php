@extends('adminlte::page')

@section('title', 'Conductores Eliminados')

@section('content_header')
    <h1>Conductores Eliminados</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('drivers.index') }}" class="btn btn-secondary mb-3">
                <i class="fa fa-arrow-left"></i> Volver a la lista de conductores
            </a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha de Eliminación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deletedDrivers as $driver)
                        <tr>
                            <td>{{ $driver->name }}</td>
                            <td>{{ $driver->deleted_at }}</td>
                            <td class="d-flex">
                                <form action="{{ route('drivers.restore', $driver->id) }}" method="POST" style="margin-right: 5px;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                                </form>
                                <form action="{{ route('drivers.forceDelete', $driver->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar definitivamente este conductor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar Definitivo</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection