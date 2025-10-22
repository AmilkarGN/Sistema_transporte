@extends('adminlte::page')

@section('title', 'Roles Combinados')

@section('content_header')
    <h1>Detalles de Roles y Usuarios</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center gap-2 mb-3">
                <form method="GET" action="{{ route('roles.combinados') }}" class="d-flex align-items-center gap-2 mb-0">
                    <input type="text" name="search" class="form-control" style="width:200px;" placeholder="Buscar..." value="{{ request('search') }}">
                    <button class="btn btn-secondary btn-sm" type="submit">Buscar</button>
                </form>
                <a href="{{ route('roles.combinados') }}" class="btn btn-outline-secondary btn-sm">
                    Cancelar búsqueda
                </a>
                <a href="{{ route('roles.combinados.reporte', ['search' => request('search')]) }}" class="btn btn-danger btn-sm">
                   <i class="fa fa-fw fa-file-pdf"></i> Generar Reporte
                </a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Rol</th>
                        <th>Usuario</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        @if($role->users->count() > 0)
                            @foreach($role->users as $user)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if(method_exists($user, 'roles'))
                                            @foreach($user->roles as $userRole)
                                                <span class="badge bg-info">{{ $userRole->name }}</span>
                                            @endforeach
                                        @else
                                            {{ $role->name }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td colspan="3" class="text-center">Sin usuarios asignados</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            {!! $roles->withQueryString()->links() !!}
        </div>
    </div>
@endsection