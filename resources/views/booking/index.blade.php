{{-- filepath: c:\xampp\htdocs\sistema_transporte\resources\views\booking\index.blade.php --}}

@extends('adminlte::page')

@section('title', 'Reservas')

@section('content_header')
    <h1>Reservas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span id="card_title">
                    Reservas
                    <form method="GET" action="{{ route('bookings.index') }}" style="display: inline-block;">
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control" 
                            placeholder="Buscar reservas" 
                            value="{{ request('search') }}" 
                            style="width: 200px; display: inline-block;"
                        >
                        <button class="btn btn-secondary btn-sm" type="submit">Buscar</button>
                    </form>
                </span>
                <div class="float-right">
                    @can('crear reservas')
                    <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm float-right" data-placement="left">
                        <i class="fas fa-plus"></i> Nueva Reserva
                    </a>
                    @endcan
                    @can('reportes reservas')
                    <a href="{{ route('bookings.report', ['search' => request('search')]) }}" class="btn btn-danger btn-sm ml-2">
                        <i class="fa fa-fw fa-file-pdf"></i> Generar Reporte
                    </a>
                    @endcan
                    @can('eliminados reservas')
                    <a href="{{ route('bookings.trashed') }}" class="btn btn-warning btn-sm ms-2">
                        <i class="fa fa-trash"></i> Ver Eliminados
                    </a>
                    @endcan
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success m-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Ruta</th>
                            <th>Fecha Solicitud</th>
                            <th>Fecha Estimada</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
    @php
        $isCliente = auth()->check() && auth()->user()->hasRole('Cliente');
        $userId = auth()->id();
    @endphp
    @foreach($bookings as $i => $booking)
        @if(!$isCliente || $booking->user_id == $userId)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $booking->user ? $booking->user->name : '-' }}</td>
            <td>{{ $booking->route ? $booking->route->name : '-' }}</td>
            <td>{{ $booking->request_date }}</td>
            <td>{{ $booking->estimated_trip_date }}</td>
            <td>
                @switch($booking->status)
                    @case('pending') Pendiente @break
                    @case('confirmed') Confirmada @break
                    @case('canceled') Cancelada @break
                    @case('rescheduled') Reprogramada @break
                    @default {{ ucfirst($booking->status) }}
                @endswitch
            </td>
            <td>
                @can('ver reservas')
                <a class="btn btn-xs btn-info" href="{{ route('bookings.show', $booking->id) }}">
                    <i class="fas fa-eye"></i>{{ __('Ver') }}</a>
                @endcan

                @can('editar reservas')
                <a class="btn btn-xs btn-warning" href="{{ route('bookings.edit', $booking->id) }}" >
                    <i class="fas fa-edit"></i>{{ __('Editar') }}</a>
                @endcan
                @can('eliminar reserva')
                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('¿Seguro de eliminar?')">
                        <i class="fas fa-trash"></i>{{ __('Eliminar') }}</button>
                </form>
                @endcan

                {{-- Botón para imprimir/regenerar factura --}}
                <a href="{{ route('bookings.regenerateComprobante', $booking->id) }}" class="btn btn-xs btn-secondary" target="_blank" title="Regenerar Factura">
                    <i class="fa fa-refresh"></i> Factura
                </a>
            </td>
        </tr>
        @endif
    @endforeach
</tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {!! $bookings->withQueryString()->links() !!}

@if(session('pdf_download'))
    <script>
        window.onload = function() {
            window.location.href = "{{ session('pdf_download') }}";
        }
    </script>
@endif
@stop