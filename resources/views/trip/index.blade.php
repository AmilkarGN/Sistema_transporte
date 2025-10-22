{{-- filepath: resources/views/trip/index.blade.php --}}
{{-- filepath: resources/views/trip/index.blade.php --}}
{{-- ... other parts of your index view ... --}}

{{-- Find the line that displays the driver's user name --}}
{{-- It might look like this: <td>{{ optional($trip->driver->user)->name ?? '-' }}</td> --}}
{{-- Or perhaps: <td>{{ $trip->driver->user->name ?? '-' }}</td> --}}

{{-- I will replace it with the corrected line using optional() on $trip->driver: --}}

{{-- ... rest of your index view ... --}}

@extends('adminlte::page')

@section('title', 'Viajes')

@section('content_header')
    <h1>Viajes</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span id="card_title">
                    Viajes
                </span>
                <form method="GET" action="{{ route('trips.index') }}" class="d-flex align-items-center">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control me-2" 
                        placeholder="Buscar viajes..." 
                        value="{{ request('search') }}" 
                        style="max-width: 250px;"
                    >
                    <button class="btn btn-secondary btn-sm" type="submit">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                </form>
                <div>
                    @can('crear viajes')
                    <a href="{{ route('trips.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Nuevo Viaje
                    </a>
                    @endcan
                    @can('reportes viajes')
                    <a href="{{ route('trips.report', ['search' => request('search')]) }}" class="btn btn-danger btn-sm ms-2">
                        <i class="fa fa-fw fa-file-pdf"></i> Generar Reporte
                    </a>
                    @endcan
                    @can('eliminados viajes')
                    <a href="{{ route('trips.trashed') }}" class="btn btn-warning btn-sm ms-2">
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
                            <th>Ruta</th>
                            <th>Vehículo</th>
                            <th>Conductor</th>
                            <th>Fecha de Salida</th>
                            <th>Llegada Estimada</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                   {{-- filepath: c:\xampp\htdocs\sistema_transporte\resources\views\trip\index.blade.php --}}
{{-- ...existing code... --}}
<tbody>
    @foreach ($trips as $trip)
        <tr>
            <td>{{ ($trips->currentPage() - 1) * $trips->perPage() + $loop->iteration }}</td>
            <td>{{ optional($trip->route)->name ?? '-' }}</td>
            <td>{{ optional($trip->vehicle)->license_plate ?? '-' }}</td>
            <td>
                {{-- Mostrar el conductor actual asignado al vehículo --}}
                @php
                    $currentDriver = null;
                    if ($trip->vehicle) {
                        $assignment = $trip->vehicle->vehicleAssignments()->latest()->first();
                        $currentDriver = $assignment && $assignment->driver && $assignment->driver->user
                            ? $assignment->driver->user->name
                            : null;
                    }
                @endphp
                {{ $currentDriver ?? '-' }}
            </td>
            <td>{{ $trip->departure_date }}</td>
            <td>{{ $trip->estimated_arrival }}</td>
            <td>{{ $trip->status }}</td>
            <td>
                {{-- ...existing code for actions... --}}
                @can('Asignar ruta')
                <a href="{{ route('trips.assign.optimal.single', $trip->id) }}" class="btn btn-success btn-xs mb-1">
                    <i class="fas fa-route"></i> Asignar ruta
                </a>
                @endcan
                @can('ver viajes')
                <a class="btn btn-xs btn-info" href="{{ route('trips.show', $trip->id) }}">
                    <i class="fas fa-eye"></i>{{ __('Ver') }}
                </a>  
                @endcan
                @can('editar viajes')  
                <a class="btn btn-xs btn-warning" href="{{ route('trips.edit', $trip->id) }}">
                    <i class="fas fa-edit"></i>{{ __('Editar') }}
                </a>
                @endcan
                @can('eliminar viajes')
                <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este viaje?')">
                        <i class="fas fa-trash"></i>{{ __('Eliminar') }}
                    </button>
                </form>
                @endcan
            </td>
        </tr>
    @endforeach
</tbody>
{{-- ...existing code... --}}
                </table>
            </div>
        </div>
    </div>
    {!! $trips->withQueryString()->links() !!}
@stop