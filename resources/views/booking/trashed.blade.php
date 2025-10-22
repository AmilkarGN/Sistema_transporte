@extends('adminlte::page')

@section('title', 'Reservas Eliminadas')

@section('content_header')
    <h1>Reservas Eliminadas Lógicamente</h1>
    <a href="{{ route('bookings.index') }}" class="btn btn-secondary btn-sm mb-2">
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
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ optional($booking->client)->name ?? '-' }}</td>
                            <td>{{ $booking->date ?? '-' }}</td>
                            <td>{{ $booking->status ?? '-' }}</td>
                            <td>
                                <form action="{{ route('bookings.forceDelete', $booking->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Eliminar definitivamente esta reserva?')">
                                        <i class="fas fa-trash"></i> Eliminar Real
                                    </button>
                                </form>
                                <form action="{{ route('bookings.restore', $booking->id) }}" method="POST" style="display:inline;">
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
            {!! $bookings->links() !!}
        </div>
    </div>
@endsection