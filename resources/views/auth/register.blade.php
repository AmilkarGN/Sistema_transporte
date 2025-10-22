@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('auth_header', 'Registrarse')

@section('auth_body')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Nombre completo" required autofocus value="{{ old('name') }}">
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-user"></span></div>
            </div>
        </div>
        @error('name') <span class="text-danger text-sm">{{ $message }}</span> @enderror

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required value="{{ old('email') }}">
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
        </div>
        @error('email') <span class="text-danger text-sm">{{ $message }}</span> @enderror

        <div class="input-group mb-3">
            <input type="text" name="phone" class="form-control" placeholder="Teléfono" required value="{{ old('phone') }}">
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-phone"></span></div>
            </div>
        </div>
        @error('phone') <span class="text-danger text-sm">{{ $message }}</span> @enderror

        <div class="input-group mb-3">
            <input type="text" name="address" class="form-control" placeholder="Dirección" required value="{{ old('address') }}">
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-map-marker-alt"></span></div>
            </div>
        </div>
        @error('address') <span class="text-danger text-sm">{{ $message }}</span> @enderror


        @error('role') <span class="text-danger text-sm">{{ $message }}</span> @enderror

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
        </div>
        @error('password') <span class="text-danger text-sm">{{ $message }}</span> @enderror

        <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
        </div>
        @error('password_confirmation') <span class="text-danger text-sm">{{ $message }}</span> @enderror

        <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
    </form>
@endsection

@section('auth_footer')
    <a href="{{ route('login') }}" class="text-center">¿Ya tienes cuenta? Inicia sesión</a>
@endsection