@extends('adminlte::page')

@section('title', 'Detalle de Asignación de Vehículo')

@section('content_header')
    <h1>Detalle de Asignación</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>Conductor:</strong> {{ optional($assignment->driver->user)->name ?? 'Sin Conductor Asignado' }}</p>
            <p><strong>Vehículo:</strong>{{ optional($assignment->vehicle)->license_plate ?? 'Vehículo Eliminado' }}</p>
            <p><strong>Fecha de Asignación:</strong> {{ $assignment->assigned_at ?? '-' }}</p>
        </div>
    </div>
    <a href="{{ route('vehicle-assignments.index') }}" class="btn btn-secondary">Volver</a>
@endsection