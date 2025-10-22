<?php

namespace App\Http\Controllers;

require_once app_path('Libraries/fpdf.php');

use App\Models\Booking;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User; // Importar modelo User
use App\Models\Route; // Importar modelo Route
use App\Models\Trip;



class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request): View
{
    $query = Booking::query(); // Iniciar la consulta de reservas

    // Mostrar solo reservas del usuario autenticado si es cliente
    if (auth()->check() && auth()->user()->hasRole('cliente')) {
        $query->where('user_id', auth()->id());
    }

    // Si hay un término de búsqueda
    if ($request->filled('search')) {
        $search = $request->input('search');
        // Filtrar por campos relevantes
        $query->where(function($q) use ($search) {
            $q->where('user_id', 'like', "%$search%")
                ->orWhere('route_id', 'like', "%$search%")
                ->orWhere('request_date', 'like', "%$search%")
                ->orWhere('estimated_trip_date', 'like', "%$search%")
                ->orWhere('status', 'like', "%$search%")
                ->orWhere('notes', 'like', "%$search%")
                ->orWhere('priority', 'like', "%$search%")
                ->orWhere('estimated_weight', 'like', "%$search%")
                ->orWhere('estimated_volume', 'like', "%$search%");
        });
    }

    $bookings = $query->paginate(10)->appends($request->query()); // Mantener los parámetros de búsqueda en la paginación

    return view('booking.index', compact('bookings'))
        ->with('i', ($request->input('page', 1) - 1) * $bookings->perPage());
}

    /**
     * Show the form for creating a new resource.
     */

public function create()
{
    $routes = Route::all();
    $trips = Trip::all();
    $booking = new Booking();

    // Para administradores/operadores: obtener solo usuarios con el rol cliente (minúscula)
    if (auth()->check() && auth()->user()->hasRole('cliente')) {
        return view('booking.create', compact('routes', 'trips', 'booking'));
    }

    $users = User::role('cliente')->get();
    return view('booking.create', compact('users', 'routes', 'trips', 'booking'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if (auth()->check() && auth()->user()->hasRole('cliente')) {
            $data['user_id'] = auth()->id();
        }

        // Asignación automática de ruta y viaje si no se seleccionaron
        if (empty($data['route_id'])) {
            $data['route_id'] = \App\Models\Route::orderBy('id')->value('id');
        }
        if (empty($data['assigned_trip_id'])) {
            $data['assigned_trip_id'] = \App\Models\Trip::orderBy('id')->value('id');
        }

        $booking = Booking::create($data);

        // Ruta del logo actualizada
        $logoPath = public_path('vendor/adminlte/dist/img/Logo1.png');

        $pdf = new \Fpdf();
        $pdf->AddPage();

        // Logo
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 10, 10, 30, 30); // x, y, width, height
        }

        // Encabezado de la factura
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetXY(50, 15);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(0, 10, utf8_decode('Factura de Reserva Realizada'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(50, 25);
        $pdf->Cell(0, 10, utf8_decode('Fecha: ') . date('d/m/Y'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(10, 40);
        $pdf->MultiCell(0, 8, utf8_decode('Oficina oficial ubicada en la ciudad del Alto, situada en la avenida Las Américas junto a la calle 3 Dolores F número 410'), 0, 'L');
        $pdf->Ln(5);

        // Datos del cliente y reserva (ajustar ancho de celdas para evitar choque de letras)
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0,0,0);

        // Usar celdas más anchas y salto de línea para valores largos
        $pdf->Cell(55, 8, utf8_decode('N° de Reserva:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 8, $booking->id, 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(55, 8, 'Cliente:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 8, $booking->user ? utf8_decode($booking->user->name) : '-', 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(55, 8, 'Ruta:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 8, $booking->route ? utf8_decode($booking->route->name) : '-', 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(55, 8, utf8_decode('Fecha de Solicitud:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 8, $booking->request_date, 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(55, 8, utf8_decode('Fecha Estimada de Viaje:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        // Si el valor es muy largo, usar MultiCell
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->MultiCell(120, 8, $booking->estimated_trip_date, 0, 'L');
        $pdf->SetXY($x + 120, $y);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(55, 10, 'Estado:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 8, ucfirst($booking->status), 0, 1, 'L');

        $pdf->Ln(10);

        // Tabla de detalles de la reserva (todo en español y valores traducidos)
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(52, 152, 219);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(60, 10, 'Detalle', 1, 0, 'C', true);
        $pdf->Cell(60, 10, 'Valor', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0,0,0);

        // Traducción de tipo de envío
        $tiposEnvio = [
            'soy' => 'Soja',
            'minerals' => 'Minerales',
            'machinery' => 'Maquinaria',
            'others' => 'Otros'
        ];
        $tipoEnvio = $booking->estimated_shipment_type ? ($tiposEnvio[$booking->estimated_shipment_type] ?? $booking->estimated_shipment_type) : '-';

        // Traducción de prioridad
        $prioridades = [
            'low' => 'Baja',
            'normal' => 'Normal',
            'high' => 'Alta'
        ];
        $prioridad = $booking->priority ? ($prioridades[$booking->priority] ?? $booking->priority) : '-';

        // Traducción de estado
        $estados = [
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmada',
            'canceled' => 'Cancelada',
            'rescheduled' => 'Reprogramada'
        ];
        $estado = $booking->status ? ($estados[$booking->status] ?? $booking->status) : '-';

        $pdf->Cell(60, 10, utf8_decode('Tipo de Envío'), 1);
        $pdf->Cell(60, 10, utf8_decode($tipoEnvio), 1, 1);
        $pdf->Cell(60, 10, utf8_decode('Peso Estimado (kg)'), 1);
        $pdf->Cell(60, 10, $booking->estimated_weight ?? '-', 1, 1);
        $pdf->Cell(60, 10, utf8_decode('Volumen Estimado (m³)'), 1);
        $pdf->Cell(60, 10, $booking->estimated_volume ?? '-', 1, 1);
        $pdf->Cell(60, 10, 'Prioridad', 1);
        $pdf->Cell(60, 10, utf8_decode($prioridad), 1, 1);

        $pdf->Cell(60, 10, 'Estado', 1);
        $pdf->Cell(60, 10, utf8_decode($estado), 1, 1);

        $pdf->Cell(60, 10, 'Notas', 1);
        $pdf->Cell(60, 10, $booking->notes ?? '-', 1, 1);

        $pdf->Ln(15);

        // Pie de página
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->SetTextColor(100,100,100);
        $pdf->Cell(0, 10, utf8_decode('¡Gracias por confiar en nuestro servicio de transporte!'), 0, 1, 'C');

        $pdfDir = storage_path('app/public/reservas');
        if (!is_dir($pdfDir)) {
            mkdir($pdfDir, 0777, true);
        }
        $pdfPath = $pdfDir . '/reserva_' . $booking->id . '.pdf';
        $pdf->Output('F', $pdfPath);

        if (!file_exists($pdfPath)) {
            return Redirect::route('bookings.index')
                ->with('error', 'No se pudo generar el comprobante PDF.');
        }

        $downloadRoute = route('bookings.downloadComprobante', $booking->id);

        return Redirect::route('bookings.index')
            ->with('success', 'Reserva realizada correctamente.')
            ->with('pdf_download', $downloadRoute);
    }
    /**
     * Display the specified resource.
     */
    public function show($id): View|RedirectResponse
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return Redirect::route('bookings.index')
                ->with('error', 'Reserva no encontrada.');
        }

        return view('booking.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $routes = Route::all();
        $trips = Trip::all();

        if (auth()->check() && auth()->user()->hasRole('cliente')) {
            return view('booking.edit', compact('booking', 'routes', 'trips'));
        }

        $users = User::role('cliente')->get();
        return view('booking.edit', compact('booking', 'users', 'routes', 'trips'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BookingRequest $request, Booking $booking): RedirectResponse
    {
        $booking->update($request->validated());

        return Redirect::route('bookings.index')
            ->with('success', 'Booking updated successfully');
    }
// Eliminado lógico
public function destroy($id)
{
    $booking = \App\Models\Booking::findOrFail($id);
    $booking->delete();
    return redirect()->route('bookings.index')->with('success', 'Reserva eliminada correctamente.');
}

// Vista de eliminados lógicos
public function trashed()
{
    $bookings = \App\Models\Booking::onlyTrashed()->paginate(10);
    return view('booking.trashed', compact('bookings'));
}

// Restaurar
public function restore($id)
{
    $booking = \App\Models\Booking::withTrashed()->findOrFail($id);
    $booking->restore();
    return redirect()->route('bookings.trashed')->with('success', 'Reserva restaurada correctamente.');
}

// Eliminado físico
public function forceDelete($id)
{
    $booking = \App\Models\Booking::onlyTrashed()->findOrFail($id);
    $booking->forceDelete();
    return redirect()->route('bookings.trashed')->with('success', 'Reserva eliminada permanentemente.');
}

public function generateReport(Request $request)
{
    $query = Booking::query();

    // Aplica el filtro si existe
    if ($request->has('search') && $request->input('search') != '') {
        $search = $request->input('search');
        $query->where('user_id', 'like', "%$search%")
              ->orWhere('route_id', 'like', "%$search%")
              ->orWhere('request_date', 'like', "%$search%")
              ->orWhere('estimated_trip_date', 'like', "%$search%")
              ->orWhere('status', 'like', "%$search%")
              ->orWhere('priority', 'like', "%$search%")
              ->orWhere('notes', 'like', "%$search%");
    }

    $bookings = $query->get();

    $pdf = new \Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Reporte de Reservas', 0, 1, 'C');
    $pdf->Ln(5);

    // Encabezado de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, '#', 1);
    $pdf->Cell(30, 10, 'Usuario', 1);
    $pdf->Cell(30, 10, 'Ruta', 1);
    $pdf->Cell(30, 10, 'Fecha Solicitud', 1);
    $pdf->Cell(30, 10, 'Fecha Estimada', 1);
    $pdf->Cell(30, 10, 'Estado', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    $i = 1;
    foreach ($bookings as $booking) {
        $pdf->Cell(10, 10, $i++, 1);
        $pdf->Cell(30, 10, utf8_decode($booking->user_id), 1);
        $pdf->Cell(30, 10, utf8_decode($booking->route_id), 1);
        $pdf->Cell(30, 10, utf8_decode($booking->request_date), 1);
        $pdf->Cell(30, 10, utf8_decode($booking->estimated_trip_date), 1);
        $pdf->Cell(30, 10, utf8_decode($booking->status), 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'reporte_reservas.pdf'); // Descarga directa
    exit;
}

public function calendarData(Request $request)
{
    $events = [];

    // Reservas
    $bookings = \App\Models\Booking::with('user', 'route')->get();
    foreach ($bookings as $booking) {
        if ($booking->estimated_trip_date) {
            $events[] = [
                'id' => 'booking-' . $booking->id,
                'title' => 'Reserva: ' . ($booking->user->name ?? 'Usuario') . ' - ' . ($booking->status ?? ''),
                'start' => date('Y-m-d', strtotime($booking->estimated_trip_date)),
                'backgroundColor' => $this->getEventColor($booking->status),
                'borderColor' => $this->getEventColor($booking->status),
                'tipo' => 'Reserva',
                // Extras para el modal
                'usuario' => $booking->user->name ?? '-',
                'ruta' => $booking->route->name ?? '-',
                'fecha_solicitud' => $booking->request_date ?? '-',
                'estado' => $booking->status ?? '-',
                'notas' => $booking->notes ?? '-',
            ];
        }
    }

    // Viajes
    $trips = \App\Models\Trip::with('driver.user', 'route')->get();
    foreach ($trips as $trip) {
        if ($trip->departure_date) {
            $events[] = [
                'id' => 'trip-' . $trip->id,
                'title' => 'Viaje: ' . ($trip->driver->user->name ?? 'Conductor') . ' - ' . ($trip->status ?? ''),
                'start' => date('Y-m-d', strtotime($trip->departure_date)),
                'backgroundColor' => '#17a2b8',
                'borderColor' => '#17a2b8',
                'tipo' => 'Viaje',
                'usuario' => $trip->driver->user->name ?? '-',
                'ruta' => $trip->route->name ?? '-',
                'fecha_solicitud' => $trip->departure_date ?? '-',
                'estado' => $trip->status ?? '-',
            ];
        }
    }

    // Envíos
    $shipments = \App\Models\Shipment::with('client', 'route')->get();
    foreach ($shipments as $shipment) {
        if ($shipment->required_date) {
            $events[] = [
                'id' => 'shipment-' . $shipment->id,
                'title' => 'Envío: ' . ($shipment->client->nombre ?? 'Cliente') . ' - ' . ($shipment->status ?? ''),
                'start' => date('Y-m-d', strtotime($shipment->required_date)),
                'backgroundColor' => '#6610f2',
                'borderColor' => '#6610f2',
                'tipo' => 'Envío',
                'usuario' => $shipment->client->nombre ?? '-',
                'ruta' => $shipment->route->name ?? '-',
                'fecha_solicitud' => $shipment->required_date ?? '-',
                'estado' => $shipment->status ?? '-',
                'notas' => $shipment->description ?? '-',
            ];
        }
    }

    // Envíos asignados
    $assignments = \App\Models\ShipmentAssignment::with('shipment.client', 'shipment.route')->get();
    foreach ($assignments as $assignment) {
        if ($assignment->delivery_date) {
            $events[] = [
                'id' => 'assignment-' . $assignment->id,
                'title' => 'Envío Asignado: ' . (optional($assignment->shipment->client)->nombre ?? 'Cliente') . ' - ' . ($assignment->status ?? ''),
                'start' => date('Y-m-d', strtotime($assignment->delivery_date)),
                'backgroundColor' => '#fd7e14',
                'borderColor' => '#fd7e14',
                'tipo' => 'Envío Asignado',
                'usuario' => optional($assignment->shipment->client)->nombre ?? '-',
                'ruta' => optional($assignment->shipment->route)->name ?? '-',
                'fecha_solicitud' => $assignment->delivery_date ?? '-',
                'estado' => $assignment->status ?? '-',
                'notas' => $assignment->notes ?? '-',
            ];
        }
    }

    return response()->json($events);
}


  /**
     * Helper function to get color based on booking status.
     */
    private function getEventColor($status)
    {
        switch ($status) {
            case 'Pending':
                return '#ffc107'; // Amarillo
            case 'Confirmed':
                return '#28a745'; // Verde
            case 'Cancelled':
                return '#dc3545'; // Rojo
            case 'Completed':
                return '#007bff'; // Azul
            default:
                return '#6c757d'; // Gris por defecto
        }
    }
    /**
     * Show the calendar view.
     */
    public function calendar(): View
    {
        return view('booking.calendar');
    }

    


    public function downloadComprobante($id)
    {
        $pdfPath = storage_path('app/public/reservas/reserva_' . $id . '.pdf');
        if (!file_exists($pdfPath)) {
            return redirect()->route('bookings.index')->with('error', 'Comprobante no encontrado.');
        }
        return response()->download($pdfPath, 'reserva_' . $id . '.pdf');
    }

    public function regenerateComprobante($id)
    {
        $booking = Booking::with(['user', 'route'])->findOrFail($id);

        // Traducciones
        $tiposEnvio = [
            'soy' => 'Soja',
            'minerals' => 'Minerales',
            'machinery' => 'Maquinaria',
            'others' => 'Otros'
        ];
        $prioridades = [
            'low' => 'Baja',
            'normal' => 'Normal',
            'high' => 'Alta'
        ];
        $estados = [
            'pending' => 'Pendiente',
            'confirmed' => 'Confirmada',
            'canceled' => 'Cancelada',
            'rescheduled' => 'Reprogramada'
        ];
        $tipoEnvio = $booking->estimated_shipment_type ? ($tiposEnvio[$booking->estimated_shipment_type] ?? $booking->estimated_shipment_type) : '-';
        $prioridad = $booking->priority ? ($prioridades[$booking->priority] ?? $booking->priority) : '-';
        $estado = $booking->status ? ($estados[$booking->status] ?? $booking->status) : '-';

        $logoPath = public_path('vendor/adminlte/dist/img/Logo1.png');
        $pdf = new \Fpdf();
        $pdf->AddPage();
        if (file_exists($logoPath)) {
            $pdf->Image($logoPath, 10, 10, 30, 30);
        }
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetXY(50, 15);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(0, 10, utf8_decode('Factura de Reserva Realizada'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(50, 25);
        $pdf->Cell(0, 10, utf8_decode('Fecha: ') . date('d/m/Y'), 0, 1, 'L');
        $pdf->SetFont('Arial', '', 11);
        $pdf->SetXY(10, 40);
        $pdf->MultiCell(0, 8, utf8_decode('Oficina oficial ubicada en la ciudad del Alto, situada en la avenida Las Américas junto a la calle 3 Dolores F número 410'), 0, 'L');
        $pdf->Ln(5);

        // Datos del cliente y reserva (ajustar ancho de celdas para evitar choque de letras)
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(55, 8, utf8_decode('N° de Reserva:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 8, $booking->id, 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(55, 8, 'Cliente:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 8, $booking->user ? utf8_decode($booking->user->name) : '-', 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(55, 8, 'Ruta:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 8, $booking->route ? utf8_decode($booking->route->name) : '-', 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(55, 8, utf8_decode('Fecha de Solicitud:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 8, $booking->request_date, 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(55, 8, utf8_decode('Fecha Estimada de Viaje:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 8, $booking->estimated_trip_date, 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(55, 10, 'Estado:', 0, 0, 'L');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(120, 8, utf8_decode($estado), 0, 1, 'L');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(52, 152, 219);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(60, 10, 'Detalle', 1, 0, 'C', true);
        $pdf->Cell(60, 10, 'Valor', 1, 1, 'C', true);

        $pdf->SetFont('Arial', '', 12);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(60, 10, utf8_decode('Tipo de Envío'), 1);
        $pdf->Cell(60, 10, utf8_decode($tipoEnvio), 1, 1);
        $pdf->Cell(60, 10, utf8_decode('Peso Estimado (kg)'), 1);
        $pdf->Cell(60, 10, $booking->estimated_weight ?? '-', 1, 1);
        $pdf->Cell(60, 10, utf8_decode('Volumen Estimado (m³)'), 1);
        $pdf->Cell(60, 10, $booking->estimated_volume ?? '-', 1, 1);
        $pdf->Cell(60, 10, 'Prioridad', 1);
        $pdf->Cell(60, 10, utf8_decode($prioridad), 1, 1);
        $pdf->Cell(60, 10, 'Estado', 1);
        $pdf->Cell(60, 10, utf8_decode($estado), 1, 1);
        $pdf->Cell(60, 10, 'Notas', 1);
        $pdf->Cell(60, 10, $booking->notes ?? '-', 1, 1);

        $pdf->Ln(15);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->SetTextColor(100,100,100);
        $pdf->Cell(0, 10, utf8_decode('¡Gracias por confiar en nuestro servicio de transporte!'), 0, 1, 'C');

        $pdfDir = storage_path('app/public/reservas');
        if (!is_dir($pdfDir)) {
            mkdir($pdfDir, 0777, true);
        }
        $pdfPath = $pdfDir . '/reserva_' . $booking->id . '.pdf';
        $pdf->Output('F', $pdfPath);

        return response()->download($pdfPath, 'reserva_' . $booking->id . '.pdf');
    }
}