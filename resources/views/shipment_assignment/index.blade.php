{{-- filepath: resources/views/shipment_assignment/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Asignaciones de Envíos')

@section('content_header')
    <h1>{{ __('Asignaciones de Envíos') }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span id="card_title">
                    {{ __('Asignaciones de Envíos') }}
                </span>

                Buscador: <!-- Formulario de búsqueda -->
                <form method="GET" action="{{ route('shipment-assignments.index') }}" class="d-flex align-items-center">
                    <input
                        type="text"
                        name="search"
                        class="form-control me-2"
                        placeholder="Buscar asignaciones de envíos..."
                        value="{{ request('search') }}"
                        style="max-width: 250px;"
                    >
                    <button class="btn btn-secondary btn-sm" type="submit">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                </form>

                <div class="float-right">
                    {{-- Botón para crear una nueva asignación de envío --}}
                    @can('crear envios asignados')
                    <a href="{{ route('shipment-assignments.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                        Crear Nuevo
                    </a>
                    @endcan
                    <!-- Botón de reporte -->
                    {{-- El filtro de búsqueda se pasa correctamente al reporte --}}
                    @can('reportes envios asignados') 
                    <a href="{{ route('shipment-assignments.report', ['search' => request('search')]) }}" class="btn btn-danger btn-sm ms-2">
                        <i class="fa fa-fw fa-file-pdf"></i> Generar Reporte
                    </a>
                    @endcan
                    {{-- Botón para ver asignaciones de envíos eliminados --}}
                    @can('eliminados envios asignados')
                    <a href="{{ route('shipment-assignments.trashed') }}" class="btn btn-warning btn-sm ms-2">
                        <i class="fa fa-trash"></i> Ver Eliminados
                    </a>
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
                            <th>Envío</th> {{-- Cambiado de Vehiculo a Envío --}}
                            <th>Conductor</th>
                            <th>Vehículo</th> {{-- Añadido campo Vehículo --}}
                            <th>Ruta</th> {{-- Añadido campo Ruta --}}
                            <th>Estado</th>
                            <th>Fecha de Asignación</th>
                            <th>Fecha de Entrega</th>
                            <th>Recibido Por</th>
                            <th>Notas</th>
                            <th>Toneladas Asignadas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    {{-- filepath: c:\xampp\htdocs\sistema_transporte\resources\views\shipment_assignment\index.blade.php --}}
{{-- ...existing code... --}}
<tbody>
    @foreach ($shipmentAssignments as $shipmentAssignment)
        <tr>
            <td>{{ ++$i }}</td>
            {{-- Envío --}}
            <td>
                {{ $shipmentAssignment->shipment->description ?? 'Envío #' . $shipmentAssignment->shipment_id ?? '-' }}
            </td>
            {{-- Conductor --}}
            <td>
                {{ $shipmentAssignment->driver && $shipmentAssignment->driver->user ? $shipmentAssignment->driver->user->name : '-' }}
            </td>
            {{-- Vehículo --}}
            <td>
                {{ $shipmentAssignment->vehicle->license_plate ?? '-' }}
            </td>
            {{-- Ruta --}}
            <td>
                {{ $shipmentAssignment->route->name
                    ?? ($shipmentAssignment->shipment && $shipmentAssignment->shipment->route ? $shipmentAssignment->shipment->route->name : '-') }}
            </td>
            <td>{{ $shipmentAssignment->status ?? '-' }}</td>
            <td>{{ $shipmentAssignment->assignment_date ?? '-' }}</td>
            <td>{{ $shipmentAssignment->delivery_date ?? '-' }}</td>
            <td>{{ $shipmentAssignment->received_by ?? '-' }}</td>
            <td>{{ $shipmentAssignment->notes ?? '-' }}</td>
            <td>{{ $shipmentAssignment->assigned_tons ?? '-' }}</td>
            <td>
                <form action="{{ route('shipment-assignments.destroy', $shipmentAssignment->id) }}" method="POST">
                    @can('ver envios asignados')
                    <a class="btn btn-sm btn-primary" href="{{ route('shipment-assignments.show', $shipmentAssignment->id) }}">
                        <i class="fa fa-fw fa-eye"></i> Ver
                    </a>
                    @endcan
                    @can('editar envios asignados')
                    <a class="btn btn-sm btn-success" href="{{ route('shipment-assignments.edit', $shipmentAssignment->id) }}">
                        <i class="fa fa-fw fa-edit"></i> Editar
                    </a>
                    @endcan
                    @csrf
                    @method('DELETE')
                    @can('eliminar envios asignados')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar?') ? this.closest('form').submit() : false;">
                        <i class="fa fa-fw fa-trash"></i> Eliminar
                    </button>
                    @endcan
                </form>
            </td>
        </tr>
    @endforeach
</tbody>
{{-- ...existing code... --}}
                                  </table>
            </div>
        </div>
    </div>
    {{-- La paginación mantiene los parámetros de búsqueda --}}
    {!! $shipmentAssignments->withQueryString()->links() !!}

</div>
@endsection

@section('css')
    {{-- Aquí puedes agregar estilos personalizados si es necesario --}}
@endsection

@section('js')
    {{-- Aquí puedes agregar scripts personalizados si es necesario --}}
@endsection
