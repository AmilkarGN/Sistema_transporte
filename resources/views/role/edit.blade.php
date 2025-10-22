{{-- filepath: c:\xampp\htdocs\sistema_transporte\resources\views\role\edit.blade.php --}}
@extends('adminlte::page')

@section('title', __('Editar Rol'))

@section('content')
    <section class="content container-fluid">
        <div class="">
            <div class="col-md-12">

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Update') }} Rol</span>
                    </div>
                    <div class="card-body bg-white">
                        <form method="POST" action="{{ route('roles.update', $role->id) }}" role="form" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            @csrf

                            @include('role.form') {{-- Incluir el formulario parcial --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection