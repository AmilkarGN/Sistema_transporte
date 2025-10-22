@extends('adminlte::page')

@section('title', 'Vehículos Eliminados')

@section('content_header')
    <h1>Vehículos Eliminados Lógicamente</h1>
    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary btn-sm mb-2">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Año</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->license_plate }}</td>
                            <td>{{ $vehicle->brand }}</td>
                            <td>{{ $vehicle->model }}</td>
                            <td>{{ $vehicle->year }}</td>
                            <td>
                                <form action="{{ route('vehicles.forceDestroy', $vehicle->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs" onclick="return confirm('¿Eliminar definitivamente?')">
                                        <i class="fa fa-trash"></i> Eliminar Físico
                                    </button>
                                </form>
                                <form action="{{ route('vehicles.restore', $vehicle->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-xs">
                                        <i class="fa fa-undo"></i> Restaurar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $vehicles->links() !!}
        </div>
    </div>
@endsection