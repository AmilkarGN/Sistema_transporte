@extends('adminlte::page')

@section('title', __('Ver Rol'))

@section('content_header')
    <h1>{{ __('Ver Rol') }}</h1>
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="float-left">
                            <span class="card-title">{{ __('Ver Rol') }}</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('roles.index') }}"> {{ __('Volver') }}</a>
                        </div>
                    </div>

                    <div class="card-body bg-white">
                        <div class="form-group mb-2 mb20">
                            <strong>Nombre:</strong>
                            {{ $role->name ?? 'Sin nombre' }}
                        </div>
                        <div class="form-group mb-2 mb20">
                            <strong>Guardia:</strong>
                            {{ $role->guard_name ?? 'Sin guardia' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection