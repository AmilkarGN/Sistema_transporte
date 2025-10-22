{{-- filepath: resources/views/route/create.blade.php --}}
@extends('adminlte::page')

@section('title', 'Crear Ruta')

@section('content_header')
    <h1>Crear Ruta</h1>
@stop

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Nueva Ruta" theme="primary" icon="fas fa-road">
                    <form method="POST" action="{{ route('routes.store') }}" role="form" enctype="multipart/form-data">
                        @csrf
                        @include('route.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </section>
@stop