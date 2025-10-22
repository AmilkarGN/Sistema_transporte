{{-- filepath: c:\xampp\htdocs\sistema_transporte\resources\views\booking\form.blade.php --}}
@php
    $isCliente = auth()->check() && auth()->user()->hasRole('cliente');
@endphp

@if(!$isCliente && isset($users) && count($users) > 0)
    <div class="form-group">
        <label for="user_id">Usuario</label>
        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
            <option value="">Seleccione un usuario</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $booking?->user_id) == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
        @error('user_id')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
@endif

@if($isCliente)
    <div class="form-group">
        <label>Cliente</label>
        <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
    </div>
    <input type="hidden" name="user_id" value="{{ auth()->id() }}">
@endif

{{-- Elimina los campos de ruta y viaje asignado, ya que se asignan automáticamente en el controlador --}}

<div class="form-group">
    <label for="request_date">Fecha de Solicitud</label>
    <input type="date" name="request_date" class="form-control @error('request_date') is-invalid @enderror"
           value="{{ old('request_date', $booking?->request_date) }}" id="request_date" placeholder="Fecha de Solicitud">
    @error('request_date')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="estimated_trip_date">Fecha Estimada de Viaje</label>
    <input type="date" name="estimated_trip_date" class="form-control @error('estimated_trip_date') is-invalid @enderror"
           value="{{ old('estimated_trip_date', $booking?->estimated_trip_date) }}" id="estimated_trip_date" placeholder="Fecha Estimada de Viaje">
    @error('estimated_trip_date')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="status">Estado</label>
    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
        <option value="">Seleccione un estado</option>
        @php
            $statuses = [
                'pending' => 'Pendiente',
                'confirmed' => 'Confirmada',
                'canceled' => 'Cancelada',
                'rescheduled' => 'Reprogramada'
            ];
        @endphp
        @foreach($statuses as $value => $label)
            <option value="{{ $value }}" {{ old('status', $booking?->status) == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('status')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="estimated_shipment_type">Tipo de Envío Estimado</label>
    <select name="estimated_shipment_type" id="estimated_shipment_type" class="form-control @error('estimated_shipment_type') is-invalid @enderror">
        <option value="">Seleccione un tipo de envío</option>
        @php
            $shipmentTypes = [
                'soy' => 'Soja',
                'minerals' => 'Minerales',
                'machinery' => 'Maquinaria',
                'others' => 'Otros'
            ];
        @endphp
        @foreach($shipmentTypes as $value => $label)
            <option value="{{ $value }}" {{ old('estimated_shipment_type', $booking?->estimated_shipment_type) == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('estimated_shipment_type')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="estimated_weight">Peso Estimado (kg)</label>
    <input type="number" name="estimated_weight" class="form-control @error('estimated_weight') is-invalid @enderror"
           value="{{ old('estimated_weight', $booking?->estimated_weight) }}" id="estimated_weight" placeholder="Peso Estimado en kg" step="0.01">
    @error('estimated_weight')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="estimated_volume">Volumen Estimado (m³)</label>
    <input type="number" name="estimated_volume" class="form-control @error('estimated_volume') is-invalid @enderror"
           value="{{ old('estimated_volume', $booking?->estimated_volume) }}" id="estimated_volume" placeholder="Volumen Estimado en m³" step="0.01">
    @error('estimated_volume')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="priority">Prioridad</label>
    <select name="priority" id="priority" class="form-control @error('priority') is-invalid @enderror">
        <option value="">Seleccione una prioridad</option>
        @php
            $priorities = [
                'low' => 'Baja',
                'normal' => 'Normal',
                'high' => 'Alta'
            ];
        @endphp
        @foreach($priorities as $value => $label)
            <option value="{{ $value }}" {{ old('priority', $booking?->priority) == $value ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('priority')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group">
    <label for="notes">Notas</label>
    <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror"
           value="{{ old('notes', $booking?->notes) }}" id="notes" placeholder="Notas">
    @error('notes')
        <span class="invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group mt-3">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> Guardar
    </button>
</div>