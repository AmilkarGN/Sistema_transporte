{{-- filepath: resources/views/route/form.blade.php --}}
{{-- Definir las opciones y sus traducciones --}}
@php
    $routeStatuses = [
        'Active' => 'Activa',
        'Inactive' => 'Inactiva',
        'Under Maintenance' => 'En Mantenimiento',
        'Closed' => 'Cerrada',
        // Agrega otros estados si es necesario
    ];

    // Opciones para puntos de riesgo del 1 al 5 con etiquetas
    $riskPointsOptions = [
        1 => '1 (Muy Bajo)',
        2 => '2 (Bajo)',
        3 => '3 (Medio)',
        4 => '4 (Alto)',
        5 => '5 (Muy Alto)',
    ];
@endphp

<div class="row p-1">
    <div class="col-md-12">
        <div class="form-group mb-2">
            <label for="name" class="form-label">Nombre de la Ruta</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $route?->name) }}" id="name" placeholder="Nombre de la ruta">
            {!! $errors->first('name', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2">
            <label for="origin" class="form-label">Origen</label>
            <input type="text" name="origin" id="origin" class="form-control @error('origin') is-invalid @enderror"
                   placeholder="Ciudad o dirección de origen" value="{{ old('origin', $route->origin ?? '') }}">
            <input type="hidden" name="origen_lat" id="origen_lat" value="{{ old('origen_lat', $route->origen_lat ?? '') }}">
            <input type="hidden" name="origen_lng" id="origen_lng" value="{{ old('origen_lng', $route->origen_lng ?? '') }}">
            {!! $errors->first('origin', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2">
            <label for="destination" class="form-label">Destino</label>
            <input type="text" name="destination" id="destination" class="form-control @error('destination') is-invalid @enderror"
                   placeholder="Ciudad o dirección de destino" value="{{ old('destination', $route->destination ?? '') }}">
            <input type="hidden" name="destino_lat" id="destino_lat" value="{{ old('destino_lat', $route->destino_lat ?? '') }}">
            <input type="hidden" name="destino_lng" id="destino_lng" value="{{ old('destino_lng', $route->destino_lng ?? '') }}">
            {!! $errors->first('destination', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2">
            <label for="distance_km" class="form-label">Distancia (Km)</label>
            {{-- Campo de solo lectura, se llenará automáticamente --}}
            <input type="text" name="distance_km" class="form-control @error('distance_km') is-invalid @enderror"
                   value="{{ old('distance_km', $route?->distance_km) }}" id="distance_km" placeholder="Distancia en kilómetros" readonly>
            {!! $errors->first('distance_km', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2">
            <label for="estimated_time_hours" class="form-label">Tiempo Estimado (Horas)</label>
            {{-- Campo de solo lectura, se llenará automáticamente --}}
            <input type="text" name="estimated_time_hours" class="form-control @error('estimated_time_hours') is-invalid @enderror"
                   value="{{ old('estimated_time_hours', $route?->estimated_time_hours) }}" id="estimated_time_hours" placeholder="Tiempo estimado en horas" readonly>
            {!! $errors->first('estimated_time_hours', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2">
            <label for="toll_booths" class="form-label">Casetas de Peaje</label>
            <input type="text" name="toll_booths" class="form-control @error('toll_booths') is-invalid @enderror"
                   value="{{ old('toll_booths', $route?->toll_booths) }}" id="toll_booths" placeholder="Número de casetas de peaje">
            {!! $errors->first('toll_booths', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2">
            <label for="estimated_toll_cost" class="form-label">Costo Estimado de Peaje (Bs)</label>
            <input type="text" name="estimated_toll_cost" class="form-control @error('estimated_toll_cost') is-invalid @enderror"
                   value="{{ old('estimated_toll_cost', $route?->estimated_toll_cost) }}" id="estimated_toll_cost" placeholder="Costo estimado de peaje">
            {!! $errors->first('estimated_toll_cost', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Estado como Selector (etiqueta modificada) --}}
        <div class="form-group mb-2">
            <label for="status" class="form-label">Estado de la Ruta</label> {{-- Etiqueta modificada --}}
            <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                <option value="">Seleccione un estado</option>
                @foreach($routeStatuses as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $route?->status) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('status', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2">
            <label for="details" class="form-label">Detalles</label>
            <input type="text" name="details" class="form-control @error('details') is-invalid @enderror"
                   value="{{ old('details', $route?->details) }}" id="details" placeholder="Detalles de la ruta">
            {!! $errors->first('details', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>

        {{-- Campo Puntos de Riesgo como Selector --}}
        <div class="form-group mb-2">
            <label for="risk_points" class="form-label">Puntos de Riesgo (1 a 5)</label>
            <select name="risk_points" class="form-control @error('risk_points') is-invalid @enderror" id="risk_points">
                <option value="">Seleccione un puntaje</option>
                @foreach($riskPointsOptions as $value => $label)
                    <option value="{{ $value }}" {{ old('risk_points', $route?->risk_points) == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('risk_points', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2">
            <label for="last_update" class="form-label">Última Actualización</label>
            {{-- Cambiado a input type="date" --}}
            <input type="date" name="last_update" class="form-control @error('last_update') is-invalid @enderror"
                   value="{{ old('last_update', $route?->last_update) }}" id="last_update" placeholder="Última actualización">
            {!! $errors->first('last_update', '<div class="invalid-feedback"><strong>:message</strong></div>') !!}
        </div>

        {{-- Contenedor para el mapa --}}
        <div class="form-group mb-2">
            <label class="form-label">Visualización de Ruta</label>
            <div id="routeMap" style="height: 400px; width: 100%;"></div>
        </div>

    </div>
    <div class="col-md-12 mt-2">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> Guardar Ruta
        </button>
    </div>
</div>

{{-- Script de Google Maps Autocomplete y Directions --}}
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2GCanK5Gxm26zDyPrKc7MNy7WhAJZK7M&libraries=places,directions"></script>
<script>
    var map;
    var directionsService;
    var directionsRenderer;
    var originAutocomplete;
    var destinationAutocomplete;

    function initMap() {
        // Inicializar el mapa
        map = new google.maps.Map(document.getElementById('routeMap'), {
            center: {lat: -16.5, lng: -68.1}, // Coordenadas iniciales (ej. La Paz, Bolivia)
            zoom: 8
        });

        // Inicializar servicios de Direcciones
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer();
        directionsRenderer.setMap(map);

        // Inicializar Autocomplete para Origen
        var inputOrigin = document.getElementById('origin');
        if (inputOrigin) {
            originAutocomplete = new google.maps.places.Autocomplete(inputOrigin);
            originAutocomplete.addListener('place_changed', function() {
                var place = originAutocomplete.getPlace();
                if (place.geometry) {
                    document.getElementById('origen_lat').value = place.geometry.location.lat();
                    document.getElementById('origen_lng').value = place.geometry.location.lng();
                    calculateAndDisplayRoute(); // Calcular y mostrar ruta al seleccionar origen
                } else {
                    // Limpiar campos si el lugar no es válido
                    document.getElementById('origen_lat').value = '';
                    document.getElementById('origen_lng').value = '';
                    clearRoute(); // Limpiar ruta si el origen se invalida
                }
            });
        }

        // Inicializar Autocomplete para Destino
        var inputDestination = document.getElementById('destination');
        if (inputDestination) {
            destinationAutocomplete = new google.maps.places.Autocomplete(inputDestination);
            destinationAutocomplete.addListener('place_changed', function() {
                var place = destinationAutocomplete.getPlace();
                if (place.geometry) {
                    document.getElementById('destino_lat').value = place.geometry.location.lat();
                    document.getElementById('destino_lng').value = place.geometry.location.lng();
                    calculateAndDisplayRoute(); // Calcular y mostrar ruta al seleccionar destino
                } else {
                     // Limpiar campos si el lugar no es válido
                    document.getElementById('destino_lat').value = '';
                    document.getElementById('destino_lng').value = '';
                    clearRoute(); // Limpiar ruta si el destino se invalida
                }
            });
        }

        // Si estamos editando y ya hay origen/destino, calcular y mostrar la ruta al cargar
        var existingOrigin = document.getElementById('origin').value;
        var existingDestination = document.getElementById('destination').value;
        if (existingOrigin && existingDestination) {
            calculateAndDisplayRoute();
        }
    }

    function calculateAndDisplayRoute() {
        var origin = document.getElementById('origin').value;
        var destination = document.getElementById('destination').value;

        if (!origin || !destination) {
            clearRoute(); // Limpiar si falta origen o destino
            return;
        }

        var request = {
            origin: origin,
            destination: destination,
            travelMode: 'DRIVING' // Puedes cambiar a 'TRANSIT', 'BICYCLING', 'WALKING' si es necesario
        };

        directionsService.route(request, function(response, status) {
            if (status === 'OK') {
                directionsRenderer.setDirections(response);

                // Extraer distancia y tiempo estimado
                var route = response.routes[0];
                var leg = route.legs[0];
                var distanceKm = (leg.distance.value / 1000).toFixed(2); // Distancia en km con 2 decimales
                var durationHours = (leg.duration.value / 3600).toFixed(2); // Tiempo en horas con 2 decimales

                // Llenar los campos del formulario
                document.getElementById('distance_km').value = distanceKm;
                document.getElementById('estimated_time_hours').value = durationHours;

            } else {
                // Manejar errores (ej. ruta no encontrada)
                window.alert('No se pudo calcular la ruta: ' + status);
                clearRoute(); // Limpiar mapa y campos si hay error
            }
        });
    }

    function clearRoute() {
        // Limpiar la ruta mostrada en el mapa
        directionsRenderer.setDirections({ routes: [] });
        // Limpiar los campos de distancia y tiempo
        document.getElementById('distance_km').value = '';
        document.getElementById('estimated_time_hours').value = '';
         // Limpiar lat/lng ocultos
        document.getElementById('origen_lat').value = '';
        document.getElementById('origen_lng').value = '';
        document.getElementById('destino_lat').value = '';
        document.getElementById('destino_lng').value = '';
    }


    // Inicializar el mapa y autocompletado cuando el DOM esté completamente cargado
    document.addEventListener('DOMContentLoaded', initMap);
</script>
