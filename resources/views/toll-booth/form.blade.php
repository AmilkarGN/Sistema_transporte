{{-- filepath: resources/views/toll-booth/form.blade.php --}}
<div class="form-group">
    <label for="name">Nombre</label>
    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $tollBooth->name ?? '') }}" id="name" placeholder="Nombre">
    @error('name')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="location">Ubicación</label>
    <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
           value="{{ old('location', $tollBooth->location ?? '') }}" id="location" placeholder="Ubicación">
    @error('location')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="route_id">ID Ruta</label>
    <input type="text" name="route_id" class="form-control @error('route_id') is-invalid @enderror"
           value="{{ old('route_id', $tollBooth->route_id ?? '') }}" id="route_id" placeholder="ID Ruta">
    @error('route_id')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="heavy_vehicle_cost">Costo Vehículo Pesado</label>
    <input type="number" step="0.01" name="heavy_vehicle_cost" class="form-control @error('heavy_vehicle_cost') is-invalid @enderror"
           value="{{ old('heavy_vehicle_cost', $tollBooth->heavy_vehicle_cost ?? '') }}" id="heavy_vehicle_cost" placeholder="Costo Vehículo Pesado">
    @error('heavy_vehicle_cost')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="operation_hours">Horario de Operación</label>
    <input type="text" name="operation_hours" class="form-control @error('operation_hours') is-invalid @enderror"
           value="{{ old('operation_hours', $tollBooth->operation_hours ?? '') }}" id="operation_hours" placeholder="Horario de Operación">
    @error('operation_hours')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="latitude">Latitud</label>
    <input type="text" name="latitude" class="form-control @error('latitude') is-invalid @enderror"
           value="{{ old('latitude', $tollBooth->latitude ?? '') }}" id="latitude" placeholder="Latitud">
    @error('latitude')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="longitude">Longitud</label>
    <input type="text" name="longitude" class="form-control @error('longitude') is-invalid @enderror"
           value="{{ old('longitude', $tollBooth->longitude ?? '') }}" id="longitude" placeholder="Longitud">
    @error('longitude')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group mt-3">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Guardar
    </button>
</div>