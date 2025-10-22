{{-- filepath: resources/views/shipment_assignment/form.blade.php --}}

@php
    $shipmentAssignment = $shipmentAssignment ?? null; // Para manejar creación/edición

    // Opciones para el estado de la asignación
    // Claves ajustadas para coincidir con los valores del ENUM en la base de datos
    $assignmentStatuses = [
        'loaded' => 'Cargado',
        'in_transit' => 'En Tránsito',
        'delivered' => 'Entregada',
        'problem' => 'Problema',
        // Puedes añadir 'Pending' o 'Assigned' si existen en tu ENUM o si los manejas lógicamente
        // Si 'Pending' y 'Assigned' no están en el ENUM de la DB, no los incluyas aquí
        // Basado en el esquema proporcionado, solo están 'loaded', 'in_transit', 'delivered', 'problem'
    ];
    
@endphp

<div class="row padding-1 p-1">
    <div class="col-md-12">

        {{-- Campo Envío como Selector --}}
        <div class="form-group mb-2 mb20">
            <label for="shipment_id" class="form-label">Envío</label>
            <select name="shipment_id" id="shipment_id" class="form-control @error('shipment_id') is-invalid @enderror" required>
                <option value="">Seleccione un envío</option>
                {{-- Asumiendo que el controlador pasa $shipments --}}
                @foreach($shipments as $shipment)
                    <option value="{{ $shipment->id }}" {{ old('shipment_id', $shipmentAssignment?->shipment_id) == $shipment->id ? 'selected' : '' }}>
                        {{ $shipment->description ?? 'Envío #' . $shipment->id }} {{-- Mostrar descripción o ID --}}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('shipment_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Conductor como Selector --}}
        <div class="form-group mb-2 mb20">
            <label for="driver_id" class="form-label">Conductor</label>
            <select name="driver_id" id="driver_id" class="form-control @error('driver_id') is-invalid @enderror" required>
                <option value="">Seleccione un conductor</option>
                 {{-- Asumiendo que el controlador pasa $drivers y que el modelo Driver tiene relación con User --}}
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ old('driver_id', $shipmentAssignment?->driver_id) == $driver->id ? 'selected' : '' }}>
                        {{ $driver->user->name ?? 'Conductor #' . $driver->id }} {{-- Mostrar nombre de usuario o ID --}}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('driver_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Vehículo como Selector --}}
        <div class="form-group mb-2 mb20">
            <label for="vehicle_id" class="form-label">Vehículo</label>
            <select name="vehicle_id" id="vehicle_id" class="form-control @error('vehicle_id') is-invalid @enderror" required>
                <option value="">Seleccione un vehículo</option>
                 {{-- Asumiendo que el controlador pasa $vehicles --}}
                @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $shipmentAssignment?->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                        {{ $vehicle->license_plate ?? 'Vehículo #' . $vehicle->id }} {{-- Mostrar placa o ID --}}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('vehicle_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Ruta como Selector --}}
        <div class="form-group mb-2 mb20">
            <label for="route_id" class="form-label">Ruta</label>
            <select name="route_id" id="route_id" class="form-control @error('route_id') is-invalid @enderror" required>
                <option value="">Seleccione una ruta</option>
                 {{-- Asumiendo que el controlador pasa $routes --}}
                @foreach($routes as $route)
                    <option value="{{ $route->id }}" {{ old('route_id', $shipmentAssignment?->route_id) == $route->id ? 'selected' : '' }}>
                        {{ $route->name ?? 'Ruta #' . $route->id }} {{-- Mostrar nombre de ruta o ID --}}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('route_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Fecha de Asignación con Calendario --}}
        <div class="form-group mb-2 mb20">
            <label for="assignment_date" class="form-label">Fecha de Asignación</label>
            {{-- Clase 'date' para Flatpickr --}}
            <input type="text" name="assignment_date" class="form-control @error('assignment_date') is-invalid @enderror date" value="{{ old('assignment_date', $shipmentAssignment?->assignment_date) }}" id="assignment_date" placeholder="Haga clic para seleccionar la fecha">
            {!! $errors->first('assignment_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Eliminados campos de hora de recogida y entrega --}}
        {{--
        <div class="form-group mb-2 mb20">
            <label for="scheduled_pickup_time" class="form-label">Hora Recogida Programada</label>
            <input type="time" name="scheduled_pickup_time" class="form-control @error('scheduled_pickup_time') is-invalid @enderror" value="{{ old('scheduled_pickup_time', $shipmentAssignment?->scheduled_pickup_time) }}" id="scheduled_pickup_time">
            {!! $errors->first('scheduled_pickup_time', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="scheduled_delivery_time" class="form-label">Hora Entrega Programada</label>
            <input type="time" name="scheduled_delivery_time" class="form-control @error('scheduled_delivery_time') is-invalid @enderror" value="{{ old('scheduled_delivery_time', $shipmentAssignment?->scheduled_delivery_time) }}" id="scheduled_delivery_time">
            {!! $errors->first('scheduled_delivery_time', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
         <div class="form-group mb-2 mb20">
            <label for="actual_pickup_time" class="form-label">Hora Recogida Real</label>
            <input type="time" name="actual_pickup_time" class="form-control @error('actual_pickup_time') is-invalid @enderror" value="{{ old('actual_pickup_time', $shipmentAssignment?->actual_pickup_time) }}" id="actual_pickup_time">
            {!! $errors->first('actual_pickup_time', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="actual_delivery_time" class="form-label">Hora Entrega Real</label>
            <input type="time" name="actual_delivery_time" class="form-control @error('actual_delivery_time') is-invalid @enderror" value="{{ old('actual_delivery_time', $shipmentAssignment?->actual_delivery_time) }}" id="actual_delivery_time">
            {!! $errors->first('actual_delivery_time', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        --}}


        {{-- Campo Estado como Selector --}}
        <div class="form-group mb-2 mb20">
            <label for="status" class="form-label">Estado</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="">Seleccione un estado</option>
                 @foreach($assignmentStatuses as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $shipmentAssignment?->status) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('status', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="notes" class="form-label">Notas</label>
            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" id="notes" placeholder="Notas adicionales">{{ old('notes', $shipmentAssignment?->notes) }}</textarea>
            {!! $errors->first('notes', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
</div>

{{-- Incluir jQuery (necesario para la lógica de conductor/vehículo) --}}
{{-- Si tu layout principal ya incluye jQuery, puedes omitir esta línea --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Incluir Flatpickr CSS y JS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
{{-- Opcional: Incluir localización en español --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>


<script>
    // Ejecutar cuando el DOM esté listo
    $(function() {
        console.log("DOM listo. Inicializando Flatpickr y lógica de conductor/vehículo."); // Log de verificación

        // Inicializar Flatpickr en los inputs con la clase 'date'
        // Asegúrate de que este script se ejecuta DESPUÉS de cargar flatpickr.js
        flatpickr(".form-control.date", {
            dateFormat: "Y-m-d", // Formato de fecha YYYY-MM-DD
            allowInput: true, // Permite escribir la fecha manualmente
            locale: "es" // Configura el idioma a español si incluiste el archivo l10n/es.js
            // Puedes añadir más opciones de configuración aquí
        });


        // Lógica para selección automática de vehículo al seleccionar conductor
        $('#driver_id').change(function() {
            var driverId = $(this).val();
            var vehicleSelect = $('#vehicle_id');

            // Limpiar y deshabilitar el selector de vehículo mientras se carga
            vehicleSelect.val('').prop('disabled', true);
            vehicleSelect.find('option:not(:first)').remove(); // Eliminar opciones anteriores excepto la primera

            if (driverId) {
                // Realizar llamada AJAX para obtener el vehículo asignado al conductor
                // Necesitarás definir esta ruta en tu web.php
                var url = '{{ url("get-vehicle-by-driver") }}/' + driverId; // Ajusta la URL si es necesario

                $.ajax({
    url: url,
    type: 'GET',
    success: function(response) {
        if (response && response.vehicle) { // <-- Aquí se accede a response.vehicle
            // Si se encontró un vehículo, añadirlo y seleccionarlo
            var vehicle = response.vehicle;
            var option = new Option(vehicle.license_plate + ' (Vehículo #' + vehicle.id + ')', vehicle.id, true, true);
            vehicleSelect.append(option);
            vehicleSelect.val(vehicle.id);
            console.log("Vehículo encontrado y seleccionado:", vehicle.license_plate);
        } else {
            // Si no se encontró vehículo o la respuesta es vacía
            console.log("No se encontró vehículo asignado para el conductor seleccionado.");
            // ... (código opcional) ...
        }
        vehicleSelect.prop('disabled', false);
    },
                });
            } else {
                // Si no se seleccionó ningún conductor, habilitar el selector de vehículo
                vehicleSelect.prop('disabled', false);
            }
        });

        // Disparar el evento change al cargar la página si ya hay un conductor seleccionado (para edición)
        if ($('#driver_id').val()) {
            $('#driver_id').trigger('change');
        }
    });
</script>
