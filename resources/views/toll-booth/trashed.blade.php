@extends('adminlte::page')

@section('title', 'Peajes Eliminados')

@section('content_header')
    <h1>Peajes Eliminados Lógicamente</h1>
    <a href="{{ route('toll-booths.index') }}" class="btn btn-secondary btn-sm mb-2">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Costo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tollBooths as $tollBooth)
                        <tr>
                            <td>{{ $tollBooth->id }}</td>
                            <td>{{ $tollBooth->name }}</td>
                            <td>{{ $tollBooth->location }}</td>
                            <td>{{ $tollBooth->cost }}</td>
                            <td>
                                <form action="{{ route('toll-booths.forceDelete', $tollBooth->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Eliminar definitivamente este peaje?')">
                                        <i class="fas fa-trash"></i> Eliminar Real
                                    </button>
                                </form>
                                <form action="{{ route('toll-booths.restore', $tollBooth->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-xs btn-success">
                                        <i class="fas fa-undo"></i> Restaurar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $tollBooths->links() !!}
        </div>
    </div>
@endsection