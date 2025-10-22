@extends('adminlte::page')

@section('title', 'Crear Viaje')

@section('content_header')
    <h1>Crear Viaje</h1>
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="{{ route('trips.store') }}">
                    @csrf
                    @include('trip.form')
                </form>
            </div>
        </div>
    </div>
@endsection