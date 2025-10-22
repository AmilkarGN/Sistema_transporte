{{-- resources/views/trip/form.blade.php --}}
<div class="row">
    <div class="col-md-6">
        <x-adminlte-select name="route_id" label="Ruta" required>
            <option value="">Seleccione una ruta</option>
            @foreach($routes as $route)
                <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>
                    {{ $route->name }}
                </option>
            @endforeach
        </x-adminlte-select>
    </div>
    <div class="col-md-6">
        <x-adminlte-select name="vehicle_id" label="Vehículo" required>
    <option value="">Seleccione un vehículo</option>
    @foreach($vehicles as $vehicle)
        <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
            {{ $vehicle->license_plate ?? 'Vehículo '.$vehicle->id }}
        </option>
    @endforeach
</x-adminlte-select>
    </div>
    <div class="col-md-6">
        <x-adminlte-select name="driver_id" label="Conductor" required>
            <option value="">Seleccione un conductor</option>
            @foreach($drivers as $driver)
                <option value="{{ $driver->id }}">{{ $driver->user->name }}</option>
            @endforeach
        </x-adminlte-select>
    </div>
    <div class="col-md-6">
        <x-adminlte-input name="departure_date" label="Fecha de Salida" type="date" value="{{ old('departure_date') }}" required/>
    </div>
    <div class="col-md-6">
        <x-adminlte-input name="estimated_arrival" label="Llegada Estimada" type="date" value="{{ old('estimated_arrival') }}" required/>
    </div>
    <div class="col-md-6">
<x-adminlte-input name="initial_mileage" label="Kilometraje Inicial" type="number" value="{{ old('initial_mileage') }}" required/>
    </div>
    <div class="col-md-6">
        <x-adminlte-select name="status" label="Estado" required>
            <option value="">Seleccione estado</option>
            <option value="pendiente" {{ old('status') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="asignado" {{ old('status') == 'asignado' ? 'selected' : '' }}>Asignado</option>
            <option value="en_progreso" {{ old('status') == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
            <option value="finalizado" {{ old('status') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
        </x-adminlte-select>
    </div>
    <div class="col-12">
        <x-adminlte-button type="submit" label="Guardar" theme="success" icon="fas fa-save"/>
    </div>
</div>
