{{-- filepath: resources/views/toll-booth/show.blade.php --}}
@extends('adminlte::page')

@section('title', 'Detalle de Caseta de Peaje')

@section('content_header')
    <h1>Detalle de Caseta de Peaje</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-adminlte-card title="Información de la Caseta" theme="info" icon="fas fa-road">
                    <dl class="row">
                        <dt class="col-sm-4">Nombre</dt>
                        <dd class="col-sm-8">{{ $tollBooth->name }}</dd>

                        <dt class="col-sm-4">Ubicación</dt>
                        <dd class="col-sm-8">{{ $tollBooth->location }}</dd>

                        <dt class="col-sm-4">ID Ruta</dt>
                        <dd class="col-sm-8">{{ $tollBooth->route_id }}</dd>

                        <dt class="col-sm-4">Costo Vehículo Pesado</dt>
                        <dd class="col-sm-8">{{ $tollBooth->heavy_vehicle_cost }}</dd>

                        <dt class="col-sm-4">Horario de Operación</dt>
                        <dd class="col-sm-8">{{ $tollBooth->operation_hours }}</dd>

                        <dt class="col-sm-4">Latitud</dt>
                        <dd class="col-sm-8">{{ $tollBooth->latitude }}</dd>

                        <dt class="col-sm-4">Longitud</dt>
                        <dd class="col-sm-8">{{ $tollBooth->longitude }}</dd>
                    </dl>
                    <a href="{{ route('toll-booths.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al listado
                    </a>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop