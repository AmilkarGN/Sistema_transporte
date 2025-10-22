@extends('adminlte::page')

@section('title', 'Envíos')

@section('content_header')
    <h1>{{ __('Envíos') }}</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span id="card_title">
                    {{ __('Envíos') }}
                </span>

                <!-- Formulario de búsqueda -->
                <form method="GET" action="{{ route('shipments.index') }}" class="d-flex align-items-center">
                    <input 
                        type="text" 
                        name="search" 
                        class="form-control me-2" 
                        placeholder="Buscar envíos..." 
                        value="{{ request('search') }}" 
                        style="max-width: 250px;"
                    >
                    <button class="btn btn-secondary btn-sm" type="submit">
                        <i class="fa fa-search"></i> Buscar
                    </button>
                </form>

                <div class="float-right">
                    <!-- Botón para crear un nuevo envío -->
                    @can('crear envios')
                    <a href="{{ route('shipments.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                        Crear Nuevo
                    </a>
                    @endcan
                    <!-- Botón de reporte -->
                    @can('reportes envios')
                    <a href="{{ route('shipments.report', ['search' => request('search')]) }}" class="btn btn-danger btn-sm ms-2">
                        <i class="fa fa-fw fa-file-pdf"></i> Generar Reporte
                    </a>
                    @endcan

                    <!-- Botón para ver envíos eliminados -->
                    @can('eliminados envios')
                    <a href="{{ route('shipments.trashed') }}" class="btn btn-warning btn-sm ms-2">
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
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Peso (Kg)</th>
                            <th>Volumen (M3)</th>
                            <th>Descripción</th>
                            <th>Fecha de Solicitud</th>
                            <th>Fecha Requerida</th>
                            <th>Estado</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Fecha Estimada de Entrega</th>
                            <th>Fecha Real de Entrega</th>
                            <th>Prioridad</th>
                            {{--<th>Requiere Refrigeración</th>--}}
                            <th>Instrucciones Especiales</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shipments as $shipment)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ optional($shipment->client->user)->name ?? '-' }}</td>
                                <td>{{ $shipment->type }}</td>
                                <td>{{ $shipment->weight_kg }}</td>
                                <td>{{ $shipment->volume_m3 }}</td>
                                <td>{{ $shipment->description }}</td>
                                <td>{{ $shipment->request_date }}</td>
                                <td>{{ $shipment->required_date }}</td>
                                <td>{{ $shipment->status }}</td>
                                <td>{{ $shipment->origin }}</td>
                                <td>{{ $shipment->destination }}</td>
                                <td>{{ $shipment->estimated_delivery_date }}</td>
                                <td>{{ $shipment->actual_delivery_date }}</td>
                                <td>{{ $shipment->priority }}</td>
                                {{--<td>{{ $shipment->requires_refrigeration }}</td>--}}
                                <td>{{ $shipment->special_instructions }}</td>
                                <td>
                                    <form action="{{ route('shipments.destroy', $shipment->id) }}" method="POST">
                                    
                                        @can('ver envios')
                                        <a class="btn btn-sm btn-primary" href="{{ route('shipments.show', $shipment->id) }}">
                                            <i class="fa fa-fw fa-eye"></i> Ver
                                        </a>
                                        @endcan
                                        @can('editar envios')
                                        <a class="btn btn-sm btn-success" href="{{ route('shipments.edit', $shipment->id) }}">
                                            <i class="fa fa-fw fa-edit"></i> Editar
                                        </a>
                                        @endcan
                                        @can('eliminar envios')
                                        <form action="{{ route('shipments.destroy', $shipment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="event.preventDefault(); confirm('¿Estás seguro de eliminar?') ? this.closest('form').submit() : false;">
                                                <i class="fa fa-fw fa-trash"></i> Eliminar
                                            </button>
                                        </form>
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
    {!! $shipments->withQueryString()->links() !!}
@endsection

@section('css')
    {{-- Aquí puedes agregar estilos personalizados si es necesario --}}
@endsection

@section('js')
    {{-- Aquí puedes agregar scripts personalizados si es necesario --}}
@endsection