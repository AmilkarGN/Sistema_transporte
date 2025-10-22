{{-- filepath: resources/views/booking/edit.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar Reserva')

@section('content_header')
    <h1>Editar Reserva</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-adminlte-card title="Editar Reserva" theme="warning" icon="fas fa-edit">
                    <form method="POST" action="{{ route('bookings.update', $booking->id) }}">
                        @csrf
                        @method('PUT')
                        @include('booking.form')
                    </form>
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop