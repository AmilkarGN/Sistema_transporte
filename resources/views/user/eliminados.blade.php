@extends('adminlte::page')

@section('title', 'Usuarios Eliminados')

@section('content_header')
    <h1>Usuarios Eliminados</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{ route('users.index') }}" class="btn btn-secondary mb-3">
                <i class="fa fa-arrow-left"></i> Volver a la lista de usuarios
            </a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha de Eliminación</th>
                        <th>Eliminado por</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deletedUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->deleted_at }}</td>
                            <td>{{ optional($user->deletedBy)->name ?? 'N/A' }}</td>
                            <td class="d-flex">
                                <form action="{{ route('users.restore', $user->id) }}" method="POST" style="margin-right: 5px;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">Restaurar</button>
                                </form>
                                <form action="{{ route('users.forceDelete', $user->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar definitivamente este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar Definitivo</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection