@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            @include('partials.menu')

            @php $role = session('role_name'); @endphp

            @if($role === 'Admin')
                <h2>Bienvenido Administrador</h2>
            @endif

            @if($role === 'Conductor')
                <h2>Bienvenido Conductor</h2>
            @endif

            @if($role === 'Cliente')
                <h2>Bienvenido Cliente</h2>
                <a href="{{ url('/reservar') }}" class="btn btn-success">Realizar Reserva</a>
                <a href="{{ url('/mis-cargas') }}" class="btn btn-info">Ver Mis Cargas</a>
            @endif

            <h1>Bienvenido al sistema de transporte</h1>
            <p>Tu rol actual es: <strong>{{ session('role_name') }}</strong></p>

            @php
                $roleId = session('role_id');
                $permisos = \App\Models\RoleHasPermission::where('role_id', $roleId)->with('permission')->get();
            @endphp

            <h4>Permisos de tu rol:</h4>
            <ul>
                @foreach($permisos as $permiso)
                    <li>{{ $permiso->permission->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection