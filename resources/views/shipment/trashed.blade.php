@extends('adminlte::page')

@section('title', 'Envíos Eliminados')

@section('content_header')
    <h1>Envíos Eliminados Lógicamente</h1>
    <a href="{{ route('shipments.index') }}" class="btn btn-secondary btn-sm mb-2">
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
                        <th>Cliente</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shipments as $shipment)
                        <tr>

                            <td>{{ $shipment->id }}</td>
                            <td>{{ optional($shipment->client)->user_id ?? '-' }}</td>
                            <td>{{ $shipment->origin }}</td>
                            <td>{{ $shipment->destination }}</td>
                            <td>{{ $shipment->status }}</td>
                            <td>
                                <form action="{{ route('shipments.forceDelete', $shipment->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Eliminar definitivamente este envío?')">
                                        <i class="fas fa-trash"></i> Eliminar Real
                                    </button>
                                </form>
                                <form action="{{ route('shipments.restore', $shipment->id) }}" method="POST" style="display:inline;">
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
            {!! $shipments->links() !!}
        </div>
    </div>
@endsection