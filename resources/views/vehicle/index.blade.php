@extends('adminlte::page')

@section('title', 'Vehicles')

@section('content_header')
    <h1>{{ __('Vehiculos') }}</h1>
@endsection

@section('content')
    {{-- Definir las opciones y sus traducciones --}}
    @php
        $vehicleTypes = [
            'Truck' => 'Camión',
            'Van' => 'Camioneta',
            'Car' => 'Automóvil',
            'Motorcycle' => 'Motocicleta',
            'Trailer' => 'Remolque',
            // Agrega otros tipos de vehículo si es necesario
        ];

        $vehicleStatuses = [
            'Available' => 'Disponible',
            'In Maintenance' => 'En Mantenimiento',
            'On Trip' => 'En Viaje',
            'Out of Service' => 'Fuera de Servicio',
            // Agrega otros estados si es necesario
        ];

        $insuranceOptions = [
            'Yes' => 'Sí',
            'No' => 'No',
        ];

        // Opciones aproximadas para Capacidad de Carga (en Toneladas)
        $loadCapacityOptions = [
            '1-5' => '1 - 5 Toneladas',
            '5-10' => '5 - 10 Toneladas',
            '10-20' => '10 - 20 Toneladas',
            '20-40' => '20 - 40 Toneladas',
            '40+' => 'Más de 40 Toneladas',
            // Ajusta estos rangos según los tipos de vehículos que manejes
        ];

        // Opciones aproximadas para Volumen de Carga (en Metros Cúbicos)
        $loadVolumeOptions = [
            '10-30' => '10 - 30 m³',
            '30-60' => '30 - 60 m³',
            '60-100' => '60 - 100 m³',
            '100+' => 'Más de 100 m³',
            // Ajusta estos rangos según los tipos de vehículos que manejes
        ];
    @endphp

    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span id="card_title">
                    {{ __('Vehiculos') }}
                </span>



                <!-- Formulario de búsqueda -->
<form method="GET" action="{{ route('vehicles.index') }}" class="d-flex align-items-center">
    <input
        type="text"
        name="search"
        class="form-control me-2"
        placeholder="Buscar vehículos por nombre, modelo, matrícula, etc..."
        value="{{ request('search') }}"
        style="max-width: 300px;"
    >
    <button class="btn btn-primary btn-sm" type="submit">
        <i class="fa fa-search"></i> Buscar
    </button>
    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary btn-sm ms-2">
        <i class="fa fa-times"></i> Limpiar
    </a>
    @can('reportes vehiculos')
    <a href="{{ route('vehicles.report', ['search' => request('search')]) }}" class="btn btn-danger btn-sm">
        <i class="fa fa-fw fa-file-pdf"></i> {{ __('Generar Reporte') }}
    </a>
    @endcan
    @can('eliminados vehiculos')
    <a href="{{ route('vehicles.trashed') }}" class="btn btn-warning btn-sm float-right ms-2">
    <i class="fa fa-trash"></i> Ver Eliminados
    @endcan
</a>

</form>
                <div class="float-right">
                    @can('crear vehiculos')
                    <a href="{{ route('vehicles.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                        {{ __('Crear Nuevo Vehiculo') }}
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
                            <th>N°</th>

                            <th>Placa</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
                            <th>Capacidad de Carga</th>
                            <th>Volumen de Carga</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Última Fecha de Mantenimiento</th>
                            <th>Próxima Fecha de Mantenimiento</th>
                            <th>Seguro Activo</th>
                            <th>Póliza de Seguro</th>
                            <th>Velocidad Promedio</th>
                            <th>Rendimiento Histórico</th>
                            <th>Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehicles as $vehicle)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $vehicle->license_plate }}</td>
                                <td>{{ $vehicle->brand }}</td>
                                <td>{{ $vehicle->model }}</td>
                                <td>{{ $vehicle->year }}</td>
                                {{-- Mostrar etiqueta en español para Capacidad de Carga --}}
                                <td>{{ $loadCapacityOptions[$vehicle->load_capacity] ?? $vehicle->load_capacity }}</td>
                                {{-- Mostrar etiqueta en español para Volumen de Carga --}}
                                <td>{{ $loadVolumeOptions[$vehicle->load_volume] ?? $vehicle->load_volume }}</td>
                                {{-- Mostrar etiqueta en español para Tipo --}}
                                <td>{{ $vehicleTypes[$vehicle->type] ?? $vehicle->type }}</td>
                                {{-- Mostrar etiqueta en español para Estado --}}
                                <td>{{ $vehicleStatuses[$vehicle->status] ?? $vehicle->status }}</td>
                                {{-- Usar optional encadenado para acceder de forma segura al nombre del usuario del conductor --}}
                                <td>{{ $vehicle->last_maintenance_date }}</td>
                                <td>{{ $vehicle->next_maintenance_date }}</td>
                                {{-- Mostrar etiqueta en español para Seguro Activo --}}
                                <td>{{ $insuranceOptions[$vehicle->active_insurance] ?? $vehicle->active_insurance }}</td>
                                <td>{{ $vehicle->insurance_policy }}</td>
                                <td>{{ $vehicle->average_speed }}</td>
                                <td>{{ $vehicle->historical_performance }}</td>
                                <td>
                                    <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST">
                                        @can('ver vehiculos')
                                        <a class="btn btn-sm btn-primary" href="{{ route('vehicles.show', $vehicle->id) }}">
                                            <i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}
                                        </a>
                                        @endcan
                                        @can('editar vehiculos')
                                        <a class="btn btn-sm btn-success" href="{{ route('vehicles.edit', $vehicle->id) }}">
                                            <i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}
                                        </a>
                                        @endcan
                                        @csrf
                                        @method('DELETE')
                                        @can('eliminar vehiculos')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Estas segur@ de borrar?') ? this.closest('form').submit() : false;">
                                            <i class="fa fa-fw fa-trash"></i> {{ __('Borrar') }}
                                        </button>
                                        @endcan
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! $vehicles->withQueryString()->links() !!}
@endsection

@section('css')
    {{-- Aquí puedes agregar estilos personalizados si es necesario --}}
@endsection

@section('js')
    {{--  --}}
@endsection
