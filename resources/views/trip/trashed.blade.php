@extends('adminlte::page')

@section('title', 'Viajes Eliminados')

@section('content_header')
    <h1>Viajes Eliminados Lógicamente</h1>
    <a href="{{ route('trips.index') }}" class="btn btn-secondary btn-sm mb-2">
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
                        <th>Conductor</th>
                        <th>Vehículo</th>
                        <th>Ruta</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trips as $trip)
                        <tr>
                            <td>{{ $trip->id }}</td>
                            <td>{{ optional($trip->driver)->name ?? '-' }}</td>
                            <td>{{ optional($trip->vehicle)->license_plate ?? '-' }}</td>
                            <td>{{ optional($trip->route)->name ?? '-' }}</td>
                            <td>{{ $trip->date ?? '-' }}</td>
                            <td>
                                <form action="{{ route('trips.forceDelete', $trip->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Eliminar definitivamente este viaje?')">
                                        <i class="fas fa-trash"></i> Eliminar Real
                                    </button>
                                </form>
                                <form action="{{ route('trips.restore', $trip->id) }}" method="POST" style="display:inline;">
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
            {!! $trips->links() !!}
        </div>
    </div>
@endsection