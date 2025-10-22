{{-- filepath: c:\xampp\htdocs\sistema_transporte\resources\views\profile\edit.blade.php --}}
@extends('adminlte::page')

@section('title', 'Editar Perfil')

@section('content_header')
    <h1>Editar Perfil</h1>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Modificar datos de usuario
                </div>
                <div class="card-body">
                    {{-- Mostrar mensajes de éxito --}}
                    @if(session('status') == 'profile-updated')
                        <div class="alert alert-success">
                            Perfil actualizado correctamente.
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4 text-center">
                            {{-- Foto de perfil --}}
                            <img src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : asset('vendor/adminlte/dist/img/avatar.png') }}"
                                 alt="Foto de perfil"
                                 class="img-thumbnail mb-2"
                                 style="width: 150px; height: 150px; object-fit: cover;">
                            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                {{-- Mantener los campos de nombre y correo ocultos para evitar error de validación --}}
                                <input type="hidden" name="name" value="{{ $user->name }}">
                                <input type="hidden" name="email" value="{{ $user->email }}">
                                <div class="form-group mt-2">
                                    <label for="profile_photo">Actualizar foto</label>
                                    <input type="file" name="profile_photo" id="profile_photo" class="form-control-file @error('profile_photo') is-invalid @enderror">
                                    @error('profile_photo')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-info btn-sm mt-2">
                                    <i class="fas fa-upload"></i> Actualizar Foto
                                </button>
                            </form>
                        </div>
                        <div class="col-md-8">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label for="email">Correo electrónico</label>
                                    <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label>Rol</label>
                                    <input type="text" class="form-control" value="{{ $user->roles->pluck('name')->implode(', ') }}" readonly>
                                </div>
                                <button type="submit" class="btn btn-success mt-3">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop