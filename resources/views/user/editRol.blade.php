@extends('adminlte::page')

@section('title', 'Editar Rol')

@section('content_header')

    <h1>Editar Rol</h1>
@stop
@section('content')
<div class="card">
    <div class="card-body">
        <p class="h5">Nombre: </p>
        <p class="form-">{{ $rol->name }}</p>
    </div>
</div>


@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
@stop
