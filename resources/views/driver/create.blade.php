@extends('adminlte::page')

@section('title', __('Crear Conductor'))

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Crear Conductor') }}</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('drivers.store') }}" role="form" enctype="multipart/form-data">
                            @csrf

                            @include('driver.form')

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