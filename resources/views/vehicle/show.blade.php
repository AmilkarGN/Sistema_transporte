@extends('adminlte::page')
@section('template_title')
    {{ $vehicle->name ?? __('Mostrar') . " " . __('Vehículo') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Vehículo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('vehicles.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Placa:</strong>
                                    {{ $vehicle->license_plate }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Marca:</strong>
                                    {{ $vehicle->brand }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Modelo:</strong>
                                    {{ $vehicle->model }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Año:</strong>
                                    {{ $vehicle->year }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Capacidad de Carga:</strong>
                                    {{ $vehicle->load_capacity }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Volumen de Carga:</strong>
                                    {{ $vehicle->load_volume }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Tipo:</strong>
                                    {{ $vehicle->type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estado:</strong>
                                    {{ $vehicle->status }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>ID del Conductor:</strong>
                                    {{ $vehicle->driver_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Última Fecha de Mantenimiento:</strong>
                                    {{ $vehicle->last_maintenance_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Próxima Fecha de Mantenimiento:</strong>
                                    {{ $vehicle->next_maintenance_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Seguro Activo:</strong>
                                    {{ $vehicle->active_insurance }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Póliza de Seguro:</strong>
                                    {{ $vehicle->insurance_policy }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Velocidad Promedio:</strong>
                                    {{ $vehicle->average_speed }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Rendimiento Histórico:</strong>
                                    {{ $vehicle->historical_performance }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection