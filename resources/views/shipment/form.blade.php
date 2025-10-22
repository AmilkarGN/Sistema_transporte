{{-- filepath: resources/views/shipment/form.blade.php --}}
@php
    $shipment = $shipment ?? null;

    // Opciones para el tipo de envío (más orientadas a carga pesada)
    $shipmentTypes = [
        'General Cargo' => 'Carga General',
        'Bulk Cargo' => 'Carga a Granel',
        'Dangerous Goods' => 'Carga Peligrosa',
        'Heavy Machinery' => 'Maquinaria Pesada',
        'Vehicles' => 'Vehículos',
        'Container' => 'Contenedor',
        'Other' => 'Otro',
    ];

    // Opciones para el estado del envío (Asegúrate que coincidan con tu DB y validación)
    $shipmentStatuses = [
        'Pending' => 'Pendiente',
        'Processing' => 'En Proceso',
        'In Transit' => 'En Tránsito',
        'Delivered' => 'Entregado',
        'Cancelled' => 'Cancelado',
    ];

    // Opciones para la prioridad del envío
    $shipmentPriorities = [
        'Low' => 'Baja',
        'Medium' => 'Media',
        'High' => 'Alta',
        'Urgent' => 'Urgente',
    ];
@endphp

<div class="row padding-1 p-1">
    <div class="col-md-12">

        {{-- filepath: resources/views/shipment_assignment/form.blade.php --}}
        @if(isset($clients))
            {{-- CREACIÓN: Seleccionar cliente --}}
            <div class="form-group mb-2 mb20">
                <label for="client_id" class="form-label">Cliente</label>
                <select name="client_id" id="client_id" class="form-control @error('client_id') is-invalid @enderror" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $shipment->client_id ?? '') == $client->id ? 'selected' : '' }}>
                            {{ $client->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('client_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
            </div>
        @else
            {{-- EDICIÓN: Mostrar nombre del cliente (siempre visible) --}}
            <div class="form-group mb-2 mb20">
                <label for="client_nombre" class="form-label">Cliente</label>
                 {{-- Mostrar el nombre del cliente asociado al envío --}}
                <input type="text" id="client_nombre" class="form-control" value="{{ $shipment->client->nombre ?? $shipment->client->name ?? '' }}" readonly>
                 {{-- Si necesitas enviar el client_id en edición, usa un campo oculto --}}
                 <input type="hidden" name="client_id" value="{{ $shipment->client_id ?? '' }}">
            </div>
        @endif

        {{-- Campo Tipo como Selector --}}
        <div class="form-group mb-2 mb20">
            <label for="type" class="form-label">Tipo de Carga</label> {{-- Etiqueta actualizada --}}
            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                <option value="">Seleccione un tipo de carga</option>
                @foreach($shipmentTypes as $value => $label)
                    <option value="{{ $value }}" {{ old('type', $shipment?->type) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('type', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Peso (Kg) como Número con Scroll --}}
        <div class="form-group mb-2 mb20">
            <label for="weight_kg" class="form-label">Peso (Kg)</label>
            {{-- Cambiado a type="number" con step y min --}}
            <input type="number" name="weight_kg" class="form-control @error('weight_kg') is-invalid @enderror" value="{{ old('weight_kg', $shipment?->weight_kg) }}" id="weight_kg" placeholder="Ej: 1500.50" step="0.01" min="0"> {{-- Placeholder y atributos numéricos --}}
            {!! $errors->first('weight_kg', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        {{-- Campo Volumen (M3) como Número con Scroll --}}
        <div class="form-group mb-2 mb20">
            <label for="volume_m3" class="form-label">Volumen (M3)</label>
             {{-- Cambiado a type="number" con step y min --}}
            <input type="number" name="volume_m3" class="form-control @error('volume_m3') is-invalid @enderror" value="{{ old('volume_m3', $shipment?->volume_m3) }}" id="volume_m3" placeholder="Ej: 10.25" step="0.01" min="0"> {{-- Placeholder y atributos numéricos --}}
            {!! $errors->first('volume_m3', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="description" class="form-label">Descripción</label>
            <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $shipment?->description) }}" id="description" placeholder="Descripción detallada de la carga"> {{-- Placeholder más descriptivo --}}
            {!! $errors->first('description', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Fecha de Solicitud con Calendario (usando clase 'date') --}}
        <div class="form-group mb-2 mb20">
            <label for="request_date" class="form-label">Fecha de Solicitud</label>
            {{-- Mantener la clase 'date' para Flatpickr --}}
            <input type="text" name="request_date" class="form-control @error('request_date') is-invalid @enderror date" value="{{ old('request_date', $shipment?->request_date) }}" id="request_date" placeholder="Haga clic para seleccionar la fecha"> {{-- Placeholder más descriptivo --}}
            {!! $errors->first('request_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Fecha Requerida con Calendario (usando clase 'date') --}}
        <div class="form-group mb-2 mb20">
            <label for="required_date" class="form-label">Fecha Requerida</label>
             {{-- Mantener la clase 'date' para Flatpickr --}}
            <input type="text" name="required_date" class="form-control @error('required_date') is-invalid @enderror date" value="{{ old('required_date', $shipment?->required_date) }}" id="required_date" placeholder="Haga clic para seleccionar la fecha"> {{-- Placeholder más descriptivo --}}
            {!! $errors->first('required_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Estado como Selector --}}
        <div class="form-group mb-2 mb20">
            <label for="status" class="form-label">Estado</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                <option value="">Seleccione un estado</option>
                 @foreach($shipmentStatuses as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $shipment?->status) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('status', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Origen con Autocompletado de Google Maps --}}
        <div class="form-group mb-2 mb20">
            <label for="origin" class="form-label">Origen</label>
            {{-- Clase para Autocomplete ya aplicada --}}
            <input type="text" name="origin" id="origin" class="form-control @error('origin') is-invalid @enderror"
                   placeholder="Ingrese ciudad o dirección de origen" value="{{ old('origin', $shipment->origin ?? '') }}" required> {{-- Placeholder más descriptivo --}}
            {{-- Campos ocultos para latitud y longitud del origen (añadidos en la migración) --}}
            <input type="hidden" name="origin_lat" id="origin_lat" value="{{ old('origin_lat', $shipment->origin_lat ?? '') }}">
            <input type="hidden" name="origin_lng" id="origin_lng" value="{{ old('origin_lng', $shipment->origin_lng ?? '') }}">
            {!! $errors->first('origin', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Destino con Autocompletado de Google Maps --}}
        <div class="form-group mb-2 mb20">
            <label for="destination" class="form-label">Destino</label>
             {{-- Clase para Autocomplete ya aplicada --}}
            <input type="text" name="destination" id="destination" class="form-control @error('destination') is-invalid @enderror"
                   placeholder="Ingrese ciudad o dirección de destino" value="{{ old('destination', $shipment->destination ?? '') }}" required> {{-- Placeholder más descriptivo --}}
             {{-- Campos ocultos para latitud y longitud del destino (añadidos en la migración) --}}
            <input type="hidden" name="destination_lat" id="destination_lat" value="{{ old('destination_lat', $shipment->destination_lat ?? '') }}">
            <input type="hidden" name="destination_lng" id="destination_lng" value="{{ old('destination_lng', $shipment->destination_lng ?? '') }}">
            {!! $errors->first('destination', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Fecha Estimada de Entrega con Calendario (usando clase 'date') --}}
        <div class="form-group mb-2 mb20">
            <label for="estimated_delivery_date" class="form-label">Fecha Estimada de Entrega</label>
             {{-- Mantener la clase 'date' para Flatpickr --}}
            <input type="text" name="estimated_delivery_date" class="form-control @error('estimated_delivery_date') is-invalid @enderror date" value="{{ old('estimated_delivery_date', $shipment?->estimated_delivery_date) }}" id="estimated_delivery_date" placeholder="Haga clic para seleccionar la fecha"> {{-- Placeholder más descriptivo --}}
            {!! $errors->first('estimated_delivery_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Fecha Real de Entrega con Calendario (usando clase 'date') --}}
        <div class="form-group mb-2 mb20">
            <label for="actual_delivery_date" class="form-label">Fecha Real de Entrega</label>
             {{-- Mantener la clase 'date' para Flatpickr --}}
            <input type="text" name="actual_delivery_date" class="form-control @error('actual_delivery_date') is-invalid @enderror date" value="{{ old('actual_delivery_date', $shipment?->actual_delivery_date) }}" id="actual_delivery_date" placeholder="Haga clic para seleccionar la fecha"> {{-- Placeholder más descriptivo --}}
            {!! $errors->first('actual_delivery_date', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Prioridad como Selector --}}
        <div class="form-group mb-2 mb20">
            <label for="priority" class="form-label">Prioridad</label>
             <select name="priority" id="priority" class="form-control @error('priority') is-invalid @enderror">
                <option value="">Seleccione una prioridad</option>
                 @foreach($shipmentPriorities as $value => $label)
                    <option value="{{ $value }}" {{ old('priority', $shipment?->priority) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('priority', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="special_instructions" class="form-label">Instrucciones Especiales</label>
            <input type="text" name="special_instructions" class="form-control @error('special_instructions') is-invalid @enderror" value="{{ old('special_instructions', $shipment?->special_instructions) }}" id="special_instructions" placeholder="Ej: Carga frágil, requiere embalaje especial"> {{-- Placeholder más descriptivo --}}
            {!! $errors->first('special_instructions', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
</div>

      {{-- ... resto del contenido de tu página ... --}}

    {{-- Scripts al final del body --}}
    {{-- Eliminadas referencias a jQuery UI Datepicker --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    {{-- <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css"> --}}

    {{-- Incluir Flatpickr CSS y JS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    {{-- Opcional: Incluir localización en español --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>


    {{-- Script de Google Maps Autocomplete --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2GCanK5Gxm26zDyPrKc7MNy7WhAJZK7M&libraries=places,directions&callback=initMap" async defer></script>

    <script>
        // Esta función será llamada por la API de Google Maps cuando esté completamente cargada
        function initMap() {
            console.log("Google Maps API cargada. Inicializando Autocomplete."); // Log de verificación

            // Inicializar Autocomplete para Origen
            var inputOrigin = document.getElementById('origin');
            var originAutocomplete;
            if (inputOrigin) {
                console.log("Elemento #origin encontrado. Inicializando Autocomplete."); // Log para depuración
                originAutocomplete = new google.maps.places.Autocomplete(inputOrigin);
                // Opcional: Restringir a un país específico si es necesario
                // originAutocomplete.setComponentRestrictions({'country': ['pe', 'bo']});
                originAutocomplete.addListener('place_changed', function() {
                    var place = originAutocomplete.getPlace();
                    if (place.geometry && place.geometry.location) {
                        document.getElementById('origin_lat').value = place.geometry.location.lat();
                        document.getElementById('origin_lng').value = place.geometry.location.lng();
                        console.log("Origen seleccionado:", place.name, "Lat:", place.geometry.location.lat(), "Lng:", place.geometry.location.lng()); // Log de coordenadas
                    } else {
                        // Limpiar campos si el lugar no es válido
                        document.getElementById('origin_lat').value = '';
                        document.getElementById('origin_lng').value = '';
                        console.error("No se encontraron detalles de geometría para el origen seleccionado.");
                    }
                });
            } else {
                 console.error("Elemento #origin no encontrado para Google Maps Autocomplete."); // Log de error
            }


            // Inicializar Autocomplete para Destino
            var inputDestination = document.getElementById('destination');
            var destinationAutocomplete;
            if (inputDestination) {
                console.log("Elemento #destination encontrado. Inicializando Autocomplete."); // Log para depuración
                destinationAutocomplete = new google.maps.places.Autocomplete(inputDestination);
                 // Opcional: Restringir a un país específico si es necesario
                // destinationAutocomplete.setComponentRestrictions({'country': ['pe', 'bo']});
                destinationAutocomplete.addListener('place_changed', function() {
                    var place = destinationAutocomplete.getPlace();
                    if (place.geometry && place.geometry.location) {
                        document.getElementById('destination_lat').value = place.geometry.location.lat();
                        document.getElementById('destination_lng').value = place.geometry.location.lng();
                         console.log("Destino seleccionado:", place.name, "Lat:", place.geometry.location.lat(), "Lng:", place.geometry.location.lng()); // Log de coordenadas
                    } else {
                         // Limpiar campos si el lugar no es válido
                        document.getElementById('destination_lat').value = '';
                        document.getElementById('destination_lng').value = '';
                        console.error("No se encontraron detalles de geometría para el destino seleccionado.");
                    }
                });
            } else {
                 console.error("Elemento #destination no encontrado para Google Maps Autocomplete."); // Log de error
            }
        }

        // Inicializar Flatpickr en los inputs con la clase 'date'
        // Asegúrate de que este script se ejecuta DESPUÉS de cargar flatpickr.js
        document.addEventListener('DOMContentLoaded', function() {
             console.log("DOM listo. Inicializando Flatpickr."); // Log de verificación
            flatpickr(".form-control.date", {
                dateFormat: "Y-m-d", // Formato de fecha YYYY-MM-DD
                allowInput: true, // Permite escribir la fecha manualmente
                locale: "es" // Configura el idioma a español si incluiste el archivo l10n/es.js
                // Puedes añadir más opciones de configuración aquí
            });
        });

        // Si aún necesitas jQuery para otras cosas, asegúrate de que se carga
        // <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        // y que tu script de inicialización de Flatpickr no dependa de $(document).ready()
        // si jQuery no está disponible globalmente o se carga de forma asíncrona.
        // El uso de document.addEventListener('DOMContentLoaded', ...) es más robusto sin jQuery.
</script>
    </script>

    </body>
</html>
