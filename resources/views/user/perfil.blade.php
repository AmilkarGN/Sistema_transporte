{{-- filepath: c:\xampp\htdocs\sistema_transporte\resources\views\user\perfil.blade.php --}}
@extends('adminlte::page')

@section('title', 'Mi Perfil')

@section('content_header')
    <h1>Mi Perfil</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <strong>Datos de Usuario</strong>
        </div>
        <div class="card-body">
            <table class="table table-bordered w-50">
                <tr>
                    <th>Nombre</th>
                    <td>{{ $user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Rol</th>
                    <td>
                        @foreach($user->roles as $rol)
                            {{ $rol->name }}
                        @endforeach
                    </td>
                </tr>
            </table>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-2">
                <i class="fas fa-edit"></i> Editar Perfil
            </a>
        </div>
    </div>
@stop