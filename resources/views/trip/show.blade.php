{{-- filepath: resources/views/trip/show.blade.php --}}
@extends('adminlte::page')

@section('title', 'Detalle de Viaje')

@section('content_header')
    <h1>Detalle de Viaje</h1>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <x-adminlte-card title="Información del Viaje" theme="info" icon="fas fa-route">
                    <dl class="row">
                        <dt class="col-sm-4">Ruta</dt>
                        <dd class="col-sm-8">{{ $trip->route->name ?? 'Sin ruta' }}</dd>

                        <dt class="col-sm-4">Vehículo</dt>
                        <dd class="col-sm-8">{{ $trip->vehicle->license_plate ?? 'Sin vehículo' }}</dd>

                        <dt class="col-sm-4">Conductor</dt>
                        <dd class="col-sm-8">{{ $trip->driver->user->name ?? 'Sin conductor' }}</dd>

                        <dt class="col-sm-4">Fecha de Salida</dt>
                        <dd class="col-sm-8">{{ $trip->departure_date }}</dd>

                        <dt class="col-sm-4">Llegada Estimada</dt>
                        <dd class="col-sm-8">{{ $trip->estimated_arrival }}</dd>

                        <dt class="col-sm-4">Estado</dt>
                        <dd class="col-sm-8">{{ $trip->status }}</dd>
                        {{-- ...otros datos del viaje... --}}
                        @if($trip->route)
                            <div class="mb-3">
                                <strong>Ruta:</strong> {{ $trip->route->name ?? 'Sin nombre' }}<br>
                                <strong>Origen:</strong> {{ $trip->route->origin }} ({{ $trip->route->origin_lat }}, {{ $trip->route->origin_lng }})<br>
                                <strong>Destino:</strong> {{ $trip->route->destination }} ({{ $trip->route->destination_lat }}, {{ $trip->route->destination_lng }})
                            </div>
                            <div id="map" style="height: 350px;"></div>
                        @endif

                        @push('css')
                        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
                        @endpush

                        @push('js')
                        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                        <script>
                        @if($trip->route)
                            var map = L.map('map').setView([{{ $trip->route->origin_lat }}, {{ $trip->route->origin_lng }}], 10);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);

                            var origen = L.marker([{{ $trip->route->origin_lat }}, {{ $trip->route->origin_lng }}]).addTo(map)
                                .bindPopup('Origen: {{ $trip->route->origin }}').openPopup();
                            var destino = L.marker([{{ $trip->route->destination_lat }}, {{ $trip->route->destination_lng }}]).addTo(map)
                                .bindPopup('Destino: {{ $trip->route->destination }}');

                            var latlngs = [
                                [{{ $trip->route->origin_lat }}, {{ $trip->route->origin_lng }}],
                                [{{ $trip->route->destination_lat }}, {{ $trip->route->destination_lng }}]
                            ];
                            var polyline = L.polyline(latlngs, {color: 'blue'}).addTo(map);
                            map.fitBounds(polyline.getBounds());
                        @endif
                        </script>
                        @endpush
                    </dl>
                    <a href="{{ route('trips.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al listado
                    </a>
                    
                </x-adminlte-card>
            </div>
        </div>
    </div>
@stop