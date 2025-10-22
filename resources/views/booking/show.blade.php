{{-- filepath: resources/views/booking/show.blade.php --}}
@extends('adminlte::page')

@section('title', 'Detalle de Reserva')

@section('content_header')
    <h1>Detalle de Reserva</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-adminlte-card title="Información de la Reserva" theme="info" icon="fas fa-calendar-alt">
                    <dl class="row">
                        <dt class="col-sm-4">Usuario</dt>
                        <dd class="col-sm-8">{{ $booking->user_id }}</dd>

                        <dt class="col-sm-4">Ruta</dt>
                        <dd class="col-sm-8">{{ $booking->route_id }}</dd>

                        <dt class="col-sm-4">Fecha de Solicitud</dt>
                        <dd class="col-sm-8">{{ $booking->request_date }}</dd>

                        <dt class="col-sm-4">Fecha Estimada de Viaje</dt>
                        <dd class="col-sm-8">{{ $booking->estimated_trip_date }}</dd>

                        <dt class="col-sm-4">Estado</dt>
                        <dd class="col-sm-8">{{ $booking->status }}</dd>

                        <dt class="col-sm-4">Tipo de Envío Estimado</dt>
                        <dd class="col-sm-8">{{ $booking->estimated_shipment_type }}</dd>

                        <dt class="col-sm-4">Peso Estimado</dt>
                        <dd class="col-sm-8">{{ $booking->estimated_weight }}</dd>

                        <dt class="col-sm-4">Volumen Estimado</dt>
                        <dd class="col-sm-8">{{ $booking->estimated_volume }}</dd>

                        <dt class="col-sm-4">Prioridad</dt>
                        <dd class="col-sm-8">{{ $booking->priority }}</dd>

                        <dt class="col-sm-4">Notas</dt>
                        <dd class="col-sm-8">{{ $booking->notes }}</dd>
                    </dl>
                    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al listado
                    </a>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop