@extends('adminlte::page')

@section('title', __('Crear Vehículo'))

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Crear Vehículo') }}</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('vehicles.store') }}" role="form" enctype="multipart/form-data">
                            @csrf

                            @include('vehicle.form')

                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection