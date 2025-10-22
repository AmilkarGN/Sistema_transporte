{{-- filepath: resources/views/toll-booth/edit.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar Caseta de Peaje')

@section('content_header')
    <h1>Editar Caseta de Peaje</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-adminlte-card title="Editar Caseta de Peaje" theme="warning" icon="fas fa-edit">
                    <form method="POST" action="{{ route('toll-booths.update', $tollBooth->id) }}">
                        @csrf
                        @method('PUT')
                        @include('toll-booth.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop