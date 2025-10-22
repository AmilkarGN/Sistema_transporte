{{-- File: resources/views/vehicle/form.blade.php --}}
<div class="row padding-1 p-1">
    <div class="col-md-12">

        {{-- Definir las opciones y sus traducciones --}}
        @php
            $vehicleTypes = [
                'Truck' => 'Camión',
                'Trailer' => 'Samurai',
                'Volvo' => 'Volvo',
                'Trailer' => 'Trailer',
                // Agrega otros tipos de vehículo si es necesario
            ];

            $vehicleStatuses = [
                'Available' => 'Disponible',
                'In Maintenance' => 'En Mantenimiento',
                'On Trip' => 'En Viaje',
                'Out of Service' => 'Fuera de Servicio',
                // Agrega otros estados si es necesario
            ];

            $insuranceOptions = [
                'Yes' => 'Sí',
                'No' => 'No',
            ];

            // Opciones aproximadas para Capacidad de Carga (en Toneladas)
            $loadCapacityOptions = [
                '1-5' => '1 - 5 Toneladas',
                '5-10' => '5 - 10 Toneladas',
                '10-20' => '10 - 20 Toneladas',
                '20-40' => '20 - 40 Toneladas',
                '40+' => 'Más de 40 Toneladas',
                // Ajusta estos rangos según los tipos de vehículos que manejes
            ];

            // Opciones aproximadas para Volumen de Carga (en Metros Cúbicos)
            $loadVolumeOptions = [
                '10-30' => '10 - 30 m³',
                '30-60' => '30 - 60 m³',
                '60-100' => '60 - 100 m³',
                '100+' => 'Más de 100 m³',
                // Ajusta estos rangos según los tipos de vehículos que manejes
            ];
        @endphp

        <div class="form-group mb-2 mb20">
            <label for="license_plate" class="form-label">Placa</label>
            <input type="text" name="license_plate" class="form-control @error('license_plate') is-invalid @enderror" value="{{ old('license_plate', $vehicle?->license_plate) }}" id="license_plate" placeholder="Placa">
            {!! $errors->first('license_plate', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="brand" class="form-label">Marca</label>
            <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" value="{{ old('brand', $vehicle?->brand) }}" id="brand" placeholder="Marca">
            {!! $errors->first('brand', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="model" class="form-label">Modelo</label>
            <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" value="{{ old('model', $vehicle?->model) }}" id="model" placeholder="Modelo">
            {!! $errors->first('model', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="year" class="form-label">Año</label>
            <input type="number" name="year" class="form-control @error('year') is-invalid @enderror"
                value="{{ old('year', $vehicle?->year) }}" id="year" placeholder="Año"
                min="1900" max="{{ date('Y')+1 }}">
            {!! $errors->first('year', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Capacidad de Carga como Selector --}}
        <div class="form-group mb-2 mb20">
            <label for="load_capacity" class="form-label">Capacidad de Carga (Aprox.)</label>
            <select name="load_capacity" class="form-control @error('load_capacity') is-invalid @enderror" id="load_capacity">
                <option value="">Seleccione una capacidad</option>
                @foreach($loadCapacityOptions as $value => $label)
                    <option value="{{ $value }}" {{ old('load_capacity', $vehicle?->load_capacity) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('load_capacity', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Volumen de Carga como Selector --}}
        <div class="form-group mb-2 mb20">
            <label for="load_volume" class="form-label">Volumen de Carga (Aprox.)</label>
            <select name="load_volume" class="form-control @error('load_volume') is-invalid @enderror" id="load_volume">
                <option value="">Seleccione un volumen</option>
                @foreach($loadVolumeOptions as $value => $label)
                    <option value="{{ $value }}" {{ old('load_volume', $vehicle?->load_volume) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('load_volume', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Tipo como Selector (ya existente) --}}
        <div class="form-group mb-2 mb20">
            <label for="type" class="form-label">Tipo</label>
            <select name="type" class="form-control @error('type') is-invalid @enderror" id="type">
                <option value="">Seleccione un tipo de Vehiculo</option>
                @foreach($vehicleTypes as $value => $label)
                    <option value="{{ $value }}" {{ old('type', $vehicle?->type) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Estado como Selector (ya existente) --}}
        <div class="form-group mb-2 mb20">
            <label for="status" class="form-label">Estado</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                <option value="">Seleccione un estado</option>
                @foreach($vehicleStatuses as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $vehicle?->status) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('status', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="last_maintenance_date" class="form-label">Última Fecha de Mantenimiento</label>
            <input type="date" name="last_maintenance_date" class="form-control @error('last_maintenance_date') is-invalid @enderror" value="{{ old('last_maintenance_date', $vehicle?->last_maintenance_date) }}" id="last_maintenance_date" placeholder="Última Fecha de Mantenimiento">
            {!! $errors->first('last_maintenance_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="next_maintenance_date" class="form-label">Próxima Fecha de Mantenimiento</label>
            <input type="date" name="next_maintenance_date" class="form-control @error('next_maintenance_date') is-invalid @enderror" value="{{ old('next_maintenance_date', $vehicle?->next_maintenance_date) }}" id="next_maintenance_date" placeholder="Próxima Fecha de Mantenimiento">
            {!! $errors->first('next_maintenance_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Seguro Activo como Selector (ya existente) --}}
        <div class="form-group mb-2 mb20">
            <label for="active_insurance" class="form-label">Seguro Activo</label>
            <select name="active_insurance" class="form-control @error('active_insurance') is-invalid @enderror" id="active_insurance">
                <option value="">Seleccione una opción</option>
                @foreach($insuranceOptions as $value => $label)
                    <option value="{{ $value }}" {{ old('active_insurance', $vehicle?->active_insurance) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('active_insurance', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="insurance_policy" class="form-label">Póliza de Seguro</label>
            <input type="text" name="insurance_policy" class="form-control @error('insurance_policy') is-invalid @enderror" value="{{ old('insurance_policy', $vehicle?->insurance_policy) }}" id="insurance_policy" placeholder="Póliza de Seguro">
            {!! $errors->first('insurance_policy', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="average_speed" class="form-label">Velocidad Promedio (km/h)</label>
            <input type="number" name="average_speed" class="form-control @error('average_speed') is-invalid @enderror"
                value="{{ old('average_speed', $vehicle?->average_speed) }}" id="average_speed" placeholder="Velocidad Promedio"
                min="0" max="200" step="0.1">
            {!! $errors->first('average_speed', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="historical_performance" class="form-label">Rendimiento Histórico</label>
            <input type="text" name="historical_performance" class="form-control @error('historical_performance') is-invalid @enderror" value="{{ old('historical_performance', $vehicle?->historical_performance) }}" id="historical_performance" placeholder="Rendimiento Histórico">
            {!! $errors->first('historical_performance', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
</div>
