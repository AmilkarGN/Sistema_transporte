@extends('adminlte::page')


@section('template_title')
    {{ $driver->name ?? __('Mostrar') . " " . __('Conductor') }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Mostrar') }} Conductor</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('drivers.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        
                                <div class="form-group mb-2 mb20">
                                <strong>Usuario:</strong>
                                {{ optional($driver->user)->name ?? '-' }}
                                 </div>
                                <div class="form-group mb-2 mb20">
                                <strong>Email:</strong>
                                {{ optional($driver->user)->email ?? '-' }}
                                 </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Número de Licencia:</strong>
                                    {{ $driver->license_number }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Vencimiento de Licencia:</strong>
                                    {{ $driver->license_expiration }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Tipo de Licencia:</strong>
                                    {{ $driver->license_type }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Estado:</strong>
                                    {{ $driver->status }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Horas de Conducción Mensuales:</strong>
                                    {{ $driver->monthly_driving_hours }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Puntaje de Seguridad:</strong>
                                    {{ $driver->safety_score }}
                                </div>
                                <div class="form-group mb-2 mb20">
                                    <strong>Última Evaluación:</strong>
                                    {{ $driver->last_evaluation }}
                                </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection