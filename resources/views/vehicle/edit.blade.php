{{-- filepath: c:\xampp\htdocs\sistema_transporte\resources\views\vehicle\edit.blade.php --}}
@extends('adminlte::page')

@section('title', __('Editar Vehículo'))

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Actualizar Vehículo') }}</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('vehicles.update', $vehicle->id) }}" role="form" enctype="multipart/form-data">
                         {{ method_field('PATCH') }}
                           @csrf

                          @include('vehicle.form')
                          {{-- filepath: c:\xampp\htdocs\sistema_transporte\resources\views\vehicle\edit.blade.php --}}
                        @if ($errors->any())
                         <div class="alert alert-danger">
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