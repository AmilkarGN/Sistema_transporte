@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Verificación de Seguridad')

@section('auth_body')
    <p class="login-box-msg">Introduce el código de 6 dígitos para validar tu acceso.</p>

    <form action="{{ route('2fa.store') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                   placeholder="Código de seguridad" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-shield-alt"></span>
                </div>
            </div>
        </div>
        @error('code')
            <span class="text-danger text-sm d-block mb-3">{{ $message }}</span>
        @enderror

        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-lock-open mr-2"></i> Verificar y Entrar
                </button>
            </div>
        </div>

        <div class="icheck-primary">
            <input type="checkbox" id="remember_device" name="remember_device">
            <label for="remember_device" class="font-weight-normal text-sm">
                <i class="fas fa-shield-alt text-primary mr-1"></i> Recordar dispositivo seguro
            </label>
        </div>
    </form>
@endsection