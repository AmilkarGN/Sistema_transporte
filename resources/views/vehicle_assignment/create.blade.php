@extends('adminlte::page')

@section('title', 'Nueva Asignación de Vehículo')

@section('content_header')
    <h1>Nueva Asignación de Vehículo a Conductor</h1>
@endsection

@section('content')
    <form action="{{ route('vehicle-assignments.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="driver_id">Conductor</label>
            <select name="driver_id" class="form-control" required>
                <option value="">Seleccione un conductor</option>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}">{{ optional($driver->user)->name ?? 'Sin usuario' }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="vehicle_id">Vehículo</label>
            <select name="vehicle_id" class="form-control" required>
                <option value="">Seleccione un vehículo</option>
                @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}">
                    ID: {{ $vehicle->id }} |
                    Placa: {{ $vehicle->license_plate ?? 'Sin placa' }} |
                    Nombre: {{ $vehicle->brand ?? 'Sin nombre' }} |
                    Modelo: {{ $vehicle->model ?? 'Sin modelo' }}
                    </option>   
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="assigned_at">Fecha de Asignación</label>
            <input type="date" name="assigned_at" class="form-control" value="{{ old('assigned_at') }}">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('vehicle-assignments.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection