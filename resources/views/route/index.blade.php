{{-- filepath: resources/views/route/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Listado de Rutas')

@section('content_header')
    <h1>Listado de Rutas</h1>
@stop

@section('content')
    <x-adminlte-card title="Rutas Registradas" theme="primary" icon="fas fa-road">
        <div class="mb-3 d-flex justify-content-between align-items-center">
            {{-- Formulario de búsqueda existente --}}
            <form method="GET" action="{{ route('routes.index') }}" class="d-flex align-items-center">
                <input
                    type="text"
                    name="search"
                    class="form-control me-2"
                    placeholder="Buscar rutas..."
                    value="{{ request('search') }}"
                    style="max-width: 250px;"
                >
                <button class="btn btn-secondary btn-sm" type="submit">
                    <i class="fa fa-search"></i> Buscar
                </button>
            </form>
            {{-- boton eliminados --}}
            @can('eliminados rutas')
            <a href="{{ route('routes.trashed') }}" class="btn btn-warning btn-sm ms-2">
                <i class="fa fa-trash"></i> Ver Eliminadas
            </a>
            @endcan
            {{-- Botón para generar reporte de rutas --}}
            @can('reportes rutas')
            <a href="{{ route('routes.report', ['search' => request('search')]) }}" class="btn btn-danger btn-sm">
                <i class="fa fa-fw fa-file-pdf"></i> Generar Reporte
            </a>
            @endcan
            {{-- Botón para crear nueva ruta --}}
            @can('crear rutas')
            <a href="{{ route('routes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Ruta
            </a>
            @endcan
        </div>

        @if ($message = Session::get('success'))
            <x-adminlte-alert theme="success" title="¡Éxito!">
                {{ $message }}
            </x-adminlte-alert>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        {{-- Encabezados de tabla en español --}}
                        <th>No</th> {{-- Cambiado de # a No --}}
                        <th>Nombre</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Distancia (Km)</th>
                        <th>Tiempo Estimado (Horas)</th> {{-- Etiqueta más clara --}}
                        <th>Estado</th>
                        <th>Dificultad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        // Definir las traducciones para el estado
                        $routeStatuses = [
                            'Active' => 'Activa',
                            'Inactive' => 'Inactiva',
                            'Under Maintenance' => 'En Mantenimiento',
                            'Closed' => 'Cerrada',
                        ];
                         // Definir las traducciones para la dificultad
                        $routeDifficulties = [
                            'low' => 'Baja',
                            'medium' => 'Media',
                            'high' => 'Alta',
                        ];
                        // Inicializar la variable $i para el contador de filas

                    @endphp
                    @foreach ($routes as $route)
                        <tr>
                            {{-- Usando $loop->iteration para el número de fila (funciona bien con paginación) --}}
                            <td>{{ ($routes->currentPage() - 1) * $routes->perPage() + $loop->iteration }}</td>
                            <td>{{ $route->name }}</td>
                            <td>{{ $route->origin }}</td>
                            <td>{{ $route->destination }}</td>
                            <td>{{ number_format($route->distance_km, 2) }}</td> {{-- Formato numérico --}}
                            <td>{{ number_format($route->estimated_time_hours, 2) }}</td> {{-- Formato numérico --}}
                            {{-- Mostrar estado traducido --}}
                            <td>{{ $routeStatuses[$route->status] ?? $route->status }}</td>
                            {{-- Mostrar dificultad traducida --}}
                            <td>{{ $routeDifficulties[$route->difficulty] ?? $route->difficulty }}</td>
                            <td>
                                {{-- Botones de acción existentes --}}
                                @can('ver rutas')
                                <a class="btn btn-xs btn-info" href="{{ route('routes.show', $route->id) }}">
                                    <i class="fas fa-eye"></i>{{ __('Ver') }}
                                </a>
                                @endcan
                                {{-- Botón para editar la ruta --}}
                                @can('editar rutas')
                                <a class="btn btn-xs btn-warning" href="{{ route('routes.edit', $route->id) }}">
                                    <i class="fas fa-edit"></i> {{ __('Editar') }}
                                </a>
                                @endcan
                                {{-- Formulario para eliminar la ruta --}}
                                @can('eliminar rutas')
                                <form action="{{ route('routes.destroy', $route->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta ruta?')">
                                        <i class="fas fa-trash"></i>{{ __('Eliminar') }}
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Paginación existente --}}
        <div>
            {!! $routes->withQueryString()->links() !!}
        </div>
    </x-adminlte-card>
@stop
