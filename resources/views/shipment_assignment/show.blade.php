
@extends('adminlte::page')
@section('template_title')
    {{ $shipmentAssignment->name ?? __('Mostrar') . " " . __('Asignación de Envío') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Asignación de Envío</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('shipment-assignments.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>Codigo de Viaje:</strong>
                                    {{ $shipmentAssignment->trip_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Codigo de Envío:</strong>
                                    {{ $shipmentAssignment->shipment_id }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estado:</strong>
                                    {{ $shipmentAssignment->status }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha de Asignación:</strong>
                                    {{ $shipmentAssignment->assignment_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha de Entrega:</strong>
                                    {{ $shipmentAssignment->delivery_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Recibido Por:</strong>
                                    {{ $shipmentAssignment->received_by }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Notas:</strong>
                                    {{ $shipmentAssignment->notes }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Toneladas Asignadas:</strong>
                                    {{ $shipmentAssignment->assigned_tons }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection