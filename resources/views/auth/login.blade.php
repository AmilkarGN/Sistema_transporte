@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Iniciar sesión')

@section('auth_body')
    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required autofocus value="{{ old('email') }}">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        @error('email')
            <span class="text-danger text-sm">{{ $message }}</span>
        @enderror

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        @error('password')
            <span class="text-danger text-sm">{{ $message }}</span>
        @enderror

        {{-- resources/views/auth/login.blade.php --}}

{{-- ... (campos de email y password) --}}

<div class="row">
    <div class="col-12 mb-3">
        {{-- Opción de Laravel Breeze por defecto --}}
        <div class="icheck-primary mb-2">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember" class="font-weight-normal text-sm">
                Recordarme
            </label>
        </div>

        {{-- Nueva opción de Dispositivo Seguro --}}

    </div>
</div>

<div class="row">
    <div class="col-12">
        <button type="submit" class="btn btn-primary btn-block">
            Ingresar
        </button>
    </div>
</div> 
</form>
@endsection

@section('auth_footer')
    @if (Route::has('password.request'))
        <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
    @endif
@endsection