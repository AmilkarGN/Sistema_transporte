{{-- filepath: resources/views/route/edit.blade.php --}}
@extends('adminlte::page')

@section('title', 'Actualizar Ruta')

@section('content_header')
    <h1>Actualizar Ruta</h1>
@stop

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Actualizar Ruta" theme="warning" icon="fas fa-edit">
                    <form method="POST" action="{{ route('routes.update', $route->id) }}" role="form" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        @include('route.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </section>
@stop