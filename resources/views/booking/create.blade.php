{{-- filepath: resources/views/booking/create.blade.php --}}

@extends('adminlte::page')

@section('title', 'Crear Reserva')

@section('content_header')
    <h1>Crear Reserva</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-adminlte-card title="Nueva Reserva" theme="primary" icon="fas fa-calendar-alt">
                    <form method="POST" action="{{ route('bookings.store') }}">
                        @csrf
                        @include('booking.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop