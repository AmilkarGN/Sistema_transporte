{{-- filepath: resources/views/toll-booth/index.blade.php --}}
@extends('adminlte::page')

@section('title', 'Casetas de Peaje')

@section('content_header')
    <h1>Casetas de Peaje</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <x-adminlte-card title="Listado de Casetas de Peaje" theme="primary" icon="fas fa-road">
                    @if ($message = Session::get('success'))
                        <x-adminlte-alert theme="success" title="¡Éxito!">
                            {{ $message }}
                        </x-adminlte-alert>
                    @endif

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <form method="GET" action="{{ route('toll-booths.index') }}" class="d-flex align-items-center">
                            <input 
                                type="text" 
                                name="search" 
                                class="form-control me-2" 
                                placeholder="Buscar casetas de peaje..." 
                                value="{{ request('search') }}" 
                                style="max-width: 250px;"
                            >
                            <button class="btn btn-secondary btn-sm" type="submit">
                                <i class="fa fa-search"></i> Buscar
                            </button>
                        </form>
                        <div>
                            @can('crear peajes')
                            <a href="{{ route('toll-booths.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Nueva Caseta
                            </a>
                            @endcan
                            @can('eliminados peajes')
                            <a href="{{ route('toll-booths.trashed') }}" class="btn btn-warning btn-sm ms-2">
                                <i class="fa fa-trash"></i> Ver Eliminados
                            </a>
                            @endcan
                            @can('reportes peajes')
                            <a href="{{ route('toll-booths.report', ['search' => request('search')]) }}" class="btn btn-danger ms-2">
                                <i class="fa fa-fw fa-file-pdf"></i> Generar Reporte
                            </a>
                            @endcan

                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Ubicación</th>
                                    <th>ID Ruta</th>
                                    <th>Costo Vehículo Pesado</th>
                                    <th>Horario de Operación</th>
                                    <th>Latitud</th>
                                    <th>Longitud</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tollBooths as $tollBooth)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $tollBooth->name }}</td>
                                        <td>{{ $tollBooth->location }}</td>
                                        <td>{{ $tollBooth->route_id }}</td>
                                        <td>{{ $tollBooth->heavy_vehicle_cost }}</td>
                                        <td>{{ $tollBooth->operation_hours }}</td>
                                        <td>{{ $tollBooth->latitude }}</td>
                                        <td>{{ $tollBooth->longitude }}</td>
                                        <td>
                                            @can('ver peajes')
                                            <a class="btn btn-xs btn-info" href="{{ route('toll-booths.show', $tollBooth->id) }}">
                                                <i class="fas fa-eye"></i>{{ __('Ver') }}
                                            </a>
                                            @endcan
                                            @can('editar peajes')
                                            <a class="btn btn-xs btn-warning" href="{{ route('toll-booths.edit', $tollBooth->id) }}">
                                                <i class="fas fa-edit"></i>{{ __('Editar') }}
                                            </a>
                                            @endcan
                                            @can('eliminar peajes')
                                            <form action="{{ route('toll-booths.destroy', $tollBooth->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Seguro que deseas eliminar esta caseta?')">
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
                    <div>
                        {!! $tollBooths->withQueryString()->links() !!}
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop