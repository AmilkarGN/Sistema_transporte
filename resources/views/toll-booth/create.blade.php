{{-- filepath: resources/views/toll-booth/create.blade.php --}}
@extends('adminlte::page')

@section('title', 'Crear Caseta de Peaje')

@section('content_header')
    <h1>Crear Caseta de Peaje</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-adminlte-card title="Nueva Caseta de Peaje" theme="primary" icon="fas fa-road">
                    <form method="POST" action="{{ route('toll-booths.store') }}">
                        @csrf
                        @include('toll-booth.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop