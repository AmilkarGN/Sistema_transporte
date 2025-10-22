@extends('adminlte::page')

@section('title', 'Conductores')

@section('content_header')
    <h1>{{ __('Conductores') }}</h1>
@endsection

@section('content')
    {{-- Definir las opciones y sus traducciones --}}
    @php
        $licenseTypes = [
            'A' => 'Tipo A',
            'B' => 'Tipo B',
            'C' => 'Tipo C',
            'D' => 'Tipo D',
            'E' => 'Tipo E',
            // Agrega otros tipos de licencia si es necesario
        ];

        $statuses = [
            'active' => 'Activo',
            'inactive' => 'Inactivo',
            'on_leave' => 'De Vacaciones',
            'suspended' => 'Suspendido',
            // Agrega otros estados si es necesario
        ];

        // Opciones para el puntaje de seguridad del 1 al 5 con etiquetas
        $safetyScores = [
            1 => '1 (Bajo)',
            2 => '2',
            3 => '3',
            4 => '4',
            5 => '5 (Alto)',
        ];
    @endphp

    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span id="card_title">
                    {{ __('Conductores') }}
                </span>

                 <!-- Formulario de búsqueda -->
                <form method="GET" action="{{ route('drivers.index') }}" class="d-flex align-items-center">
                    <input
                        type="text"
                        name="search"
                        class="form-control me-2"
                        placeholder="Buscar conductores..."
                        value="{{ request('search') }}"
                        style="max-width: 300px;"
                    >
                    <button class="btn btn-primary btn-sm" type="submit">
                        <i class="fa fa-search"></i> Buscar
                    </button>


                    <a href="{{ route('drivers.index') }}" class="btn btn-secondary btn-sm ms-2">
                        <i class="fa fa-times"></i> Limpiar
                    </a>

                    @can('reportes conductores')
                     <a href="{{ route('drivers.report') }}" class="btn btn-danger btn-sm">
                        <i class="fa fa-fw fa-file-pdf"></i> {{ __('Generar Reporte') }}
                    </a> 
                    @endcan

                    @can ('eliminados conductores')
                     <a href="{{ route('drivers.eliminados') }}" class="btn btn-warning btn-sm float-right ms-2">
                        <i class="fa fa-trash"></i> Ver Eliminados
                    </a>
                    @endauth
                </form>


                <div class="float-right">
                    @can('crear conductores')
                    <a href="{{ route('drivers.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                        {{ __('Crear Nuevo Conductor') }}
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
                            <th>Usuario</th>
                            <th>Número de Licencia</th>
                            <th>Vencimiento de Licencia</th>
                            <th>Tipo de Licencia</th>
                            <th>Estado</th>
                            <th>Horas de Conducción Mensuales</th>
                            <th>Puntaje de Seguridad</th>
                            <th>Última Evaluación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($drivers as $driver)
                            <tr>
                                <td>{{ ++$i }}</td>
                                {{-- Usar optional para acceder de forma segura al nombre del usuario --}}
                                <td>{{ optional($driver->user)->name ?? 'Usuario no asignado' }}</td>
                                <td>{{ $driver->license_number }}</td>
                                <td>{{ $driver->license_expiration }}</td>
                                {{-- Mostrar etiqueta en español para Tipo de Licencia --}}
                                <td>{{ $licenseTypes[$driver->license_type] ?? $driver->license_type }}</td>
                                {{-- Mostrar etiqueta en español para Estado --}}
                                <td>{{ $statuses[$driver->status] ?? $driver->status }}</td>
                                <td>{{ $driver->monthly_driving_hours }}</td>
                                {{-- Mostrar etiqueta en español para Puntaje de Seguridad --}}
                                <td>{{ $safetyScores[$driver->safety_score] ?? $driver->safety_score }}</td>
                                <td>{{ $driver->last_evaluation }}</td>
                                <td>
                                    <form action="{{ route('drivers.destroy', $driver->id) }}" method="POST">
                                        @can('ver conductores')
                                        <a class="btn btn-sm btn-primary" href="{{ route('drivers.show', $driver->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Ver') }}</a>
                                        @endcan

                                        {{-- Botón para editar --}}
                                        @can('editar conductores')
                                        <a class="btn btn-sm btn-success" href="{{ route('drivers.edit', $driver->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Editar') }}</a>
                                        @endcan

                                        @csrf
                                        @method('DELETE')
                                        @can('eliminar conductores')   
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('Estas segur@ de borrar?') ? this.closest('form').submit() : false;"><i class="fa fa-fw fa-trash"></i> {{ __('Eliminar') }}</button>
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
    {!! $drivers->withQueryString()->links() !!}
@endsection

@section('css')
    {{-- Aquí puedes agregar estilos personalizados si es necesario --}}
@endsection

@section('js')
    {{--  --}}
@endsection
