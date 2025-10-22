@extends('adminlte::page')

@section('title', 'Asignaciones de Envíos Eliminadas')

@section('content_header')
    <h1>Asignaciones de Envíos Eliminadas</h1>
    <a href="{{ route('shipment-assignments.index') }}" class="btn btn-secondary btn-sm mb-2">
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
                        <th>Envío</th>
                        <th>Conductor</th>
                        <th>Vehículo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->id }}</td>
                            <td>{{ optional($assignment->shipment)->id ?? '-' }}</td>
                            <td>{{ optional($assignment->driver)->name ?? '-' }}</td>
                            <td>{{ optional($assignment->vehicle)->license_plate ?? '-' }}</td>
                            <td>
                                <form action="{{ route('shipment-assignments.forceDelete', $assignment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Eliminar definitivamente esta asignación?')">
                                        <i class="fas fa-trash"></i> Eliminar Real
                                    </button>
                                </form>
                                <form action="{{ route('shipment-assignments.restore', $assignment->id) }}" method="POST" style="display:inline;">
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
            {!! $assignments->links() !!}
        </div>
    </div>
@endsection