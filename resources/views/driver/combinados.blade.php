@extends('adminlte::page')

@section('title', 'Conductores Combinados')

@section('content_header')
    <h1>Conductores, Usuarios y Viajes Realizados</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center gap-2 mb-3">
                <form method="GET" action="{{ route('conductores.combinados') }}" class="d-flex align-items-center gap-2 mb-0">
                    <input type="text" name="search" class="form-control" style="width:200px;" placeholder="Buscar..." value="{{ request('search') }}">
                    <button class="btn btn-secondary btn-sm" type="submit">Buscar</button>
                </form>
                <a href="{{ route('conductores.combinados') }}" class="btn btn-outline-secondary btn-sm">
                    Cancelar búsqueda
                </a>
                <a href="{{ route('conductores.combinados.reporte', ['search' => request('search')]) }}" class="btn btn-danger btn-sm">
    <i class="fa fa-fw fa-file-pdf"></i> Generar Reporte
</a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre Usuario</th>
                        <th>Email</th>
                        <th>Viajes Realizados</th>
                        <th>Número de Licencia</th>
                        <th>Tipo de Licencia</th>
                        <th>Estado</th>
                        <th>Vencimiento Licencia</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($drivers as $driver)
                        <tr>
                            <td>{{ $driver->user->name ?? '-' }}</td>
                            <td>{{ $driver->user->email ?? '-' }}</td>
                            <td>{{ $driver->trips->count() }}</td>
                            <td>{{ $driver->license_number }}</td>
                            <td>{{ $driver->license_type }}</td>
                            <td>{{ $driver->status }}</td>
                            <td>{{ $driver->license_expiration }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $drivers->withQueryString()->links() !!}
        </div>
    </div>
@endsection