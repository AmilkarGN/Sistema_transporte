
@extends('adminlte::page')

@section('template_title')
    {{ $shipment->name ?? __('Mostrar') . " " . __('Envío') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Envío</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('shipments.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                    <strong>ID de Usuario:</strong>
                                    {{ optional($shipment->client)->user_id ?? '-' }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Tipo:</strong>
                                    {{ $shipment->type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Peso (Kg):</strong>
                                    {{ $shipment->weight_kg }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Volumen (M3):</strong>
                                    {{ $shipment->volume_m3 }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Descripción:</strong>
                                    {{ $shipment->description }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha de Solicitud:</strong>
                                    {{ $shipment->request_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Requerida:</strong>
                                    {{ $shipment->required_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estado:</strong>
                                    {{ $shipment->status }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Origen:</strong>
                                    {{ $shipment->origin }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Destino:</strong>
                                    {{ $shipment->destination }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Estimada de Entrega:</strong>
                                    {{ $shipment->estimated_delivery_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Fecha Real de Entrega:</strong>
                                    {{ $shipment->actual_delivery_date }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Prioridad:</strong>
                                    {{ $shipment->priority }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Requiere Refrigeración:</strong>
                                    {{ $shipment->requires_refrigeration }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Instrucciones Especiales:</strong>
                                    {{ $shipment->special_instructions }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection