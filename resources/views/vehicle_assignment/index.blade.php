@extends('adminlte::page')

@section('title', 'Asignaciones de Vehículos')

@section('content_header')
    <h1>Asignaciones de Vehículos a Conductores</h1>
@endsection

@section('content')
    <div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
        <form method="GET" action="{{ route('vehicle-assignments.index') }}" class="d-flex align-items-center" style="max-width:400px;">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Buscar por conductor o vehículo..." value="{{ request('search') }}">
            <button class="btn btn-secondary btn-sm" type="submit"><i class="fa fa-search"></i> Buscar</button>
        </form>
        <div class="ms-auto d-flex gap-2">
            @can('crear asignacion vehiculos')
            <a href="{{ route('vehicle-assignments.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Nueva Asignación
            </a>
            @endcan
            @can('eliminados asignacion vehiculos')
            <a href="{{ route('vehicle-assignments.trashed') }}" class="btn btn-warning btn-sm">
                <i class="fas fa-trash-restore"></i> Ver eliminados
            </a>
            @endcan
            {{-- Botón para generar reporte de asignaciones --}}
            @can('reportes asignacion vehiculos')
            <a href="{{ route('vehicle-assignments.report', ['search' => request('search')]) }}" class="btn btn-danger btn-sm">
                <i class="fa fa-file-pdf"></i> Generar Reporte
            </a>
            @endcan
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Conductor</th>
                <th>Vehículo</th>
                <th>Fecha de Asignación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignments as $assignment)
                <tr>
                    
                    <td>{{ optional(optional($assignment->driver)->user)->name ?? 'Sin Conductor Asignado' }}</td>
                    <td>{{ optional($assignment->vehicle)->license_plate ?? 'Vehículo Eliminado' }}</td> {{-- Muestra la placa del vehículo, o un mensaje si el vehículo fue eliminado --}}

                    <td>{{ $assignment->assigned_at ?? '-' }}</td>
                    <td>
                        @can('ver asignacion vehiculos')
                        <a href="{{ route('vehicle-assignments.show', $assignment->id) }}" class="btn btn-info btn-xs">
                            <i class="fa fa-eye"></i> Ver
                        </a>
                        @endcan
                        @can('editar asignacion vehiculos')
                        <a href="{{ route('vehicle-assignments.edit', $assignment->id) }}" class="btn btn-warning btn-xs">
                            Editar
                        </a>
                        @endcan
                        {{-- Formulario para eliminar la asignación --}}
                        @can('eliminar asignacion vehiculos')
                        <form action="{{ route('vehicle-assignments.destroy', $assignment->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-xs" onclick="return confirm('¿Eliminar asignación?')">Eliminar</button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {!! $assignments->links() !!}
@endsection