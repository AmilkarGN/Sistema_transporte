@extends('adminlte::page')

@section('title', 'Formulario de Usuario')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ isset($user->id) ? __('Editar Usuario') : __('Crear Usuario') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ isset($user->id) ? route('users.update', $user->id) : route('users.store') }}" method="POST" enctype="multipart/form-data"> {{-- Agregado enctype for file uploads --}}
                @csrf
                @if(isset($user->id))
                    @method('PUT')
                @endif

                <!-- Campos del formulario -->
                <div class="form-group">

                    <label for="name">{{ __('Nombre') }}</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name ?? '') }}" placeholder="Nombre">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Correo Electrónico') }}</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email ?? '') }}" placeholder="Correo Electrónico">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="profile_photo">Foto de perfil</label>
                    <input type="file" class="form-control @error('profile_photo') is-invalid @enderror" name="profile_photo" id="profile_photo" accept="image/*"> {{-- Added error class --}}
                    @error('profile_photo') {{-- Added error message display for profile_photo --}}
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">{{ __('Teléfono') }}</label>
                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone ?? '') }}" placeholder="Teléfono">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">{{ __('Dirección') }}</label>
                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->address ?? '') }}" placeholder="Dirección">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="role">{{ __('Rol') }}</label>
                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                        <option value="">{{ __('Seleccione un rol') }}</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}"
                            {{ (old('role', (isset($user) && $user && $user->roles->first() ? $user->roles->first()->name : '')) == $role->name) ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>

                        @endforeach
                    </select>
                    {{-- El @error('role') se movió aquí, fuera del select --}}
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Campo para la contraseña -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Contraseña') }}</label> {{-- Added translation --}}
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" {{ isset($user->id) ? '' : 'required' }} minlength="8"> {{-- Made required only for creation --}}
                    @error('password') {{-- Added error message display for password --}}
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Campo para confirmar contraseña -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Confirmar Contraseña') }}</label> {{-- Added translation --}}
                    <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" {{ isset($user->id) ? '' : 'required' }} minlength="8"> {{-- Made required only for creation --}}
                    @error('password_confirmation') {{-- Added error message display for password_confirmation --}}
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <button type="submit" class="btn btn-primary">{{ isset($user->id) ? __('Actualizar') : __('Crear') }}</button>
            </form>
        </div>
    </div>

    </div>
@endsection
