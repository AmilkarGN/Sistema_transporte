{{-- filepath: resources/views/trip/edit.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar Viaje')

@section('content_header')
    <h1>Editar Viaje</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-adminlte-card title="Editar Viaje" theme="warning" icon="fas fa-edit">
                    <form method="POST" action="{{ route('trips.update', $trip->id) }}">
                        @csrf
                        @method('PUT')
                        @include('trip.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop