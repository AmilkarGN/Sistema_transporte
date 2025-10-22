{{-- filepath: resources/views/route/show.blade.php --}}
@extends('adminlte::page')

@section('template_title')
    {{ $route->name }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2>Detalles de la Ruta: {{ $route->name }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Origen:</strong> {{ $route->origin }}</p>
                                <p><strong>Destino:</strong> {{ $route->destination }}</p>
                                <p><strong>Distancia (Km):</strong> {{ number_format($route->distance_km, 2) ?? 'N/A' }}</p>
                                <p><strong>Tiempo Estimado (Horas):</strong> {{ number_format($route->estimated_time_hours, 2) ?? 'N/A' }}</p>
                                <p><strong>Casetas de Peaje:</strong> {{ $route->toll_booths ?? 'N/A' }}</p>
                                <p><strong>Costo Estimado de Peaje (Bs):</strong> {{ number_format($route->estimated_toll_cost, 2) ?? 'N/A' }}</p>
                                @php
                                    // Definir las traducciones para el estado (debe coincidir con form.blade.php o ser global)
                                    $routeStatuses = [
                                        'Active' => 'Activa',
                                        'Inactive' => 'Inactiva',
                                        'Under Maintenance' => 'En Mantenimiento',
                                        'Closed' => 'Cerrada',
                                    ];
                                    // Definir las traducciones para la dificultad (debe coincidir con form.blade.php o ser global)
                                    $routeDifficulties = [
                                        'low' => 'Baja',
                                        'medium' => 'Media',
                                        'high' => 'Alta',
                                    ];
                                    // Definir las traducciones para puntos de riesgo (debe coincidir con form.blade.php o ser global)
                                    $riskPointsLabels = [
                                        1 => '1 (Muy Bajo)',
                                        2 => '2 (Bajo)',
                                        3 => '3 (Medio)',
                                        4 => '4 (Alto)',
                                        5 => '5 (Muy Alto)',
                                    ];
                                @endphp
                                <p><strong>Estado:</strong> {{ $routeStatuses[$route->status] ?? $route->status }}</p>
                                <p><strong>Dificultad:</strong> {{ $routeDifficulties[$route->difficulty] ?? $route->difficulty ?? 'N/A' }}</p>
                                <p><strong>Puntos de Riesgo (1 a 5):</strong> {{ $riskPointsLabels[$route->risk_points] ?? $route->risk_points ?? 'N/A' }}</p>
                                <p><strong>Última Actualización:</strong> {{ $route->last_update ? \Carbon\Carbon::parse($route->last_update)->format('d/m/Y H:i') : 'N/A' }}</p>
                                <p><strong>Detalles:</strong> {{ $route->details ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                {{-- Contenedor para el mapa --}}
                                <div class="form-group mb-2">
                                    <label class="form-label">Visualización de Ruta</label>
                                    <div id="routeMap" style="height: 400px; width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script de Google Maps Autocomplete y Directions --}}
    {{-- Reemplaza YOUR_API_KEY con tu clave real --}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2GCanK5Gxm26zDyPrKc7MNy7WhAJZK7M&libraries=places,directions"></script>
    <script>
        var map;
        var directionsService;
        var directionsRenderer;

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

            // Obtener origen y destino de los datos de la ruta pasados a la vista
            var origin = "{{ $route->origin }}";
            var destination = "{{ $route->destination }}";

            if (origin && destination) {
                calculateAndDisplayRoute(origin, destination);
            } else {
                 // Si no hay origen o destino, simplemente centrar el mapa
                 map.setCenter({lat: -16.5, lng: -68.1}); // O alguna otra coordenada por defecto
            }
        }

        function calculateAndDisplayRoute(origin, destination) {
            var request = {
                origin: origin,
                destination: destination,
                travelMode: 'DRIVING'
            };

            directionsService.route(request, function(response, status) {
                if (status === 'OK') {
                    directionsRenderer.setDirections(response);
                    // Opcional: centrar y ajustar zoom para mostrar toda la ruta
                    map.fitBounds(response.routes[0].bounds);
                } else {
                    // Manejar errores (ej. ruta no encontrada)
                    console.error('No se pudo calcular la ruta: ' + status);
                    // Mostrar un mensaje en el mapa o en la consola
                }
            });
        }

        // Inicializar el mapa cuando el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', initMap);
    </script>
@endsection
{{-- filepath: resources/views/route/show.blade.php --}}
@extends('adminlte::page')

@section('title', 'Detalle de Ruta')

@section('content_header')
    <h1>Detalle de Ruta</h1>
@stop

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <x-adminlte-card title="Información de la Ruta" theme="info" icon="fas fa-road">
                    <dl class="row">
                        <dt class="col-sm-4">Nombre</dt>
                        <dd class="col-sm-8">{{ $route->name }}</dd>

                        <dt class="col-sm-4">Origen</dt>
                        <dd class="col-sm-8">{{ $route->origin }}</dd>

                        <dt class="col-sm-4">Destino</dt>
                        <dd class="col-sm-8">{{ $route->destination }}</dd>

                        <dt class="col-sm-4">Distancia (Km)</dt>
                        <dd class="col-sm-8">{{ $route->distance_km }}</dd>

                        <dt class="col-sm-4">Tiempo Estimado (h)</dt>
                        <dd class="col-sm-8">{{ $route->estimated_time_hours }}</dd>

                        <dt class="col-sm-4">Casetas de Peaje</dt>
                        <dd class="col-sm-8">{{ $route->toll_booths }}</dd>

                        <dt class="col-sm-4">Costo Estimado de Peaje (Bs)</dt>
                        <dd class="col-sm-8">{{ $route->estimated_toll_cost }}</dd>

                        <dt class="col-sm-4">Estado</dt>
                        <dd class="col-sm-8">{{ ucfirst($route->status) }}</dd>

                        <dt class="col-sm-4">Dificultad</dt>
                        <dd class="col-sm-8">{{ ucfirst($route->difficulty) }}</dd>

                        <dt class="col-sm-4">Detalles</dt>
                        <dd class="col-sm-8">{{ $route->details }}</dd>

                        <dt class="col-sm-4">Puntos de Riesgo</dt>
                        <dd class="col-sm-8">{{ $route->risk_points }}</dd>

                        <dt class="col-sm-4">Última Actualización</dt>
                        <dd class="col-sm-8">{{ $route->last_update }}</dd>
                    </dl>
                    <div class="mb-3">
                        <h4>Mapa de la Ruta</h4>
                        <div id="map" style="height: 400px;"></div>
                    </div>
                </x-adminlte-card>
            </div>
        </div>
    </section>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var origenLat = {{ $route->origen_lat ?? 0 }};
            var origenLng = {{ $route->origen_lng ?? 0 }};
            var destinoLat = {{ $route->destino_lat ?? 0 }};
            var destinoLng = {{ $route->destino_lng ?? 0 }};

            var map = L.map('map').setView([origenLat, origenLng], 8);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            }).addTo(map);

            var origenMarker = L.marker([origenLat, origenLng]).addTo(map)
                .bindPopup('Origen: {{ $route->origin }}').openPopup();

            var destinoMarker = L.marker([destinoLat, destinoLng]).addTo(map)
                .bindPopup('Destino: {{ $route->destination }}');

            var latlngs = [
                [origenLat, origenLng],
                [destinoLat, destinoLng]
            ];
            var polyline = L.polyline(latlngs, {color: 'blue'}).addTo(map);
            map.fitBounds(polyline.getBounds());
        });
    </script>
@stop