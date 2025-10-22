{{-- filepath: resources/views/booking/calendar.blade.php --}}

@extends('adminlte::page')

@section('title', 'Calendario de Reservas')

@section('content_header')
    <h1>Calendario de Reservas</h1>
    <div class="mb-2">
    <span class="badge" style="background:#6c757d;">Reserva</span>
    <span class="badge" style="background:#17a2b8;">Viaje</span>
    <span class="badge" style="background:#6610f2;">Envío</span>
    <span class="badge" style="background:#fd7e14;">Envío Asignado</span>
</div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
@stop

@section('js')

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: '{{ route('bookings.calendar-data') }}',
                eventClick: function(info) {
                var evento = info.event.extendedProps;
                let mensaje = '';
                switch (evento.tipo) {
                    case 'Reserva':
                        mensaje =
                            'Tipo: Reserva\n' +
                            'Usuario: ' + (evento.usuario ?? '') + '\n' +
                            'Ruta: ' + (evento.ruta ?? '') + '\n' +
                            'Fecha de Solicitud: ' + (evento.fecha_solicitud ?? '') + '\n' +
                            'Fecha Estimada: ' + (info.event.startStr ?? '') + '\n' +
                            'Estado: ' + (evento.estado ?? '') + '\n' +
                            'Notas: ' + (evento.notas ?? '');
                        break;
                    case 'Viaje':
                        mensaje =
                            'Tipo: Viaje\n' +
                            'Conductor: ' + (evento.usuario ?? '') + '\n' +
                            'Ruta: ' + (evento.ruta ?? '') + '\n' +
                            'Fecha de Salida: ' + (evento.fecha_solicitud ?? '') + '\n' +
                            'Estado: ' + (evento.estado ?? '');
                        break;
                    case 'Envío':
                        mensaje =
                            'Tipo: Envío\n' +
                            'Cliente: ' + (evento.usuario ?? '') + '\n' +
                            'Ruta: ' + (evento.ruta ?? '') + '\n' +
                            'Fecha de Envío: ' + (evento.fecha_solicitud ?? '') + '\n' +
                            'Estado: ' + (evento.estado ?? '') + '\n' +
                            'Descripción: ' + (evento.notas ?? '');
                        break;
                    default:
                        mensaje = 'Tipo: ' + (evento.tipo ?? '') + '\n' + info.event.title;
                }
                alert(mensaje);
            }
            });
            calendar.render();
        });
    </script>
@stop