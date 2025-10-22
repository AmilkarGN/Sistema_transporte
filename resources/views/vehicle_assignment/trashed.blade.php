@extends('adminlte::page')

@section('title', 'Asignaciones Eliminadas')

@section('content_header')
    <h1>Asignaciones de Vehículos Eliminadas</h1>
@stop

@section('content')
    <x-adminlte-card title="Asignaciones Eliminadas" theme="danger" icon="fas fa-trash">
        <a href="{{ route('vehicle-assignments.index') }}" class="btn btn-secondary mb-3">
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
                        <th>Conductor</th>
                        <th>Vehículo</th>
                        <th>Fecha de Asignación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assignments as $assignment)
                        <tr>
                            <td>{{ optional($assignment->driver->user)->name ?? '-' }}</td>
                            <td>{{ $assignment->vehicle->license_plate ?? '-' }}</td>
                            <td>{{ $assignment->assigned_at ?? '-' }}</td>
                            <td>
                                <form action="{{ route('vehicle-assignments.force-delete', $assignment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Eliminar definitivamente esta asignación?')">
                                        <i class="fas fa-trash"></i> Eliminar Real
                                    </button>

                                </form>
                                <form action="{{ route('vehicle-assignments.restore', $assignment->id) }}" method="POST" style="display:inline;">
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
            {!! $assignments->links() !!}
        </div>
    </x-adminlte-card>
@stop