<?php

namespace App\Http\Controllers;

require_once app_path('Libraries/fpdf.php');

use App\Models\Trip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TripRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
{
    $trips = Trip::with('driver.user')->paginate(); // Esto ya carga las relaciones
    return view('trip.index', compact('trips'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
{

    $trip = new Trip();
    $routes = \App\Models\Route::all();
    $vehicles = \App\Models\Vehicle::all();
    $drivers = \App\Models\Driver::with('user')->get();
return view('trip.create', compact('trip', 'routes', 'vehicles', 'drivers'));}
    /**
     * Store a newly created resource in storage.
     */
    public function store(TripRequest $request): RedirectResponse
    {
        Trip::create($request->validated());

        return Redirect::route('trips.index')
            ->with('success', 'Trip created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Trip $trip)
{
    $trip->load('route', 'vehicle', 'driver');
    return view('trip.show', compact('trip'));
}

    /**
     * Show the form for editing the specified resource.
     */

public function edit($id): View
{
    $trip = Trip::find($id);
    $routes = \App\Models\Route::all();
    $vehicles = \App\Models\Vehicle::all();
    $drivers = \App\Models\Driver::with('user')->get();

    return view('trip.edit', compact('trip', 'routes', 'vehicles', 'drivers'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(TripRequest $request, Trip $trip): RedirectResponse
    {
        $trip->update($request->validated());

        return Redirect::route('trips.index')
            ->with('success', 'Trip updated successfully');
    }
// Eliminado lógico
public function destroy($id)
{
    $trip = \App\Models\Trip::findOrFail($id);
    $trip->delete();
    return redirect()->route('trips.index')->with('success', 'Viaje eliminado correctamente.');
}

// Vista de eliminados lógicos
public function trashed()
{
    $trips = \App\Models\Trip::onlyTrashed()->paginate(10);
    return view('trip.trashed', compact('trips'));
}

// Restaurar
public function restore($id)
{
    $trip = \App\Models\Trip::withTrashed()->findOrFail($id);
    $trip->restore();
    return redirect()->route('trips.trashed')->with('success', 'Viaje restaurado correctamente.');
}

// Eliminado físico
public function forceDelete($id)
{
    $trip = \App\Models\Trip::onlyTrashed()->findOrFail($id);
    $trip->forceDelete();
    return redirect()->route('trips.trashed')->with('success', 'Viaje eliminado permanentemente.');
}
    

public function assignOptimalRouteToTrip($tripId)
{
    $trip = \App\Models\Trip::findOrFail($tripId);
    $route = $trip->route;
    if (!$route) {
        return back()->with('error', 'El viaje no tiene ruta asociada.');
    }

    $drivers = \App\Models\Driver::with('vehicles')->whereHas('vehicles')->get();

    $bestDriver = null;
    $bestVehicle = null;
    $bestDistance = null;

    foreach ($drivers as $driver) {
        $vehicle = $driver->vehicles->first();
        if (!$vehicle) continue;

        $distance = $this->haversine(
            $driver->current_lat, $driver->current_lng,
            $route->origin_lat, $route->origin_lng
        );
        if (is_null($bestDistance) || $distance < $bestDistance) {
            $bestDistance = $distance;
            $bestDriver = $driver;
            $bestVehicle = $vehicle;
        }
    }

    if ($bestDriver && $bestVehicle) {
        $trip->driver_id = $bestDriver->id;
        $trip->vehicle_id = $bestVehicle->id;
        $trip->status = 'asignado';
        $trip->save();
        return back()->with('success', 'Ruta, conductor y vehículo asignados óptimamente.');
    } else {
        return back()->with('error', 'No hay conductores o vehículos disponibles.');
    }
}

// Ecuación de Haversine
private function haversine($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);

    $a = sin($dLat/2) * sin($dLat/2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon/2) * sin($dLon/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $earthRadius * $c;
}

public function generateReport(Request $request)
{
    $query = Trip::query();

    // Aplica el filtro si existe
    if ($request->has('search') && $request->input('search') != '') {
        $search = $request->input('search');
        $query->where('route_id', 'like', "%$search%")
              ->orWhere('vehicle_id', 'like', "%$search%")
              ->orWhere('driver_id', 'like', "%$search%")
              ->orWhere('departure_date', 'like', "%$search%")
              ->orWhere('status', 'like', "%$search%");
    }

    $trips = $query->get();

    $pdf = new \Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Reporte de Viajes', 0, 1, 'C');
    $pdf->Ln(5);

    // Encabezado de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, '#', 1);
    $pdf->Cell(30, 10, 'Ruta', 1);
    $pdf->Cell(30, 10, 'Vehículo', 1);
    $pdf->Cell(30, 10, 'Conductor', 1);
    $pdf->Cell(40, 10, 'Fecha Salida', 1);
    $pdf->Cell(40, 10, 'Estado', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    $i = 1;
    foreach ($trips as $trip) {
        $pdf->Cell(10, 10, $i++, 1);
        $pdf->Cell(30, 10, utf8_decode($trip->route_id), 1);
        $pdf->Cell(30, 10, utf8_decode($trip->vehicle_id), 1);
        $pdf->Cell(30, 10, utf8_decode($trip->driver_id), 1);
        $pdf->Cell(40, 10, utf8_decode($trip->departure_date), 1);
        $pdf->Cell(40, 10, utf8_decode($trip->status), 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'reporte_viajes.pdf'); // Descarga directa
    exit;
}

// Si en tu TripController usabas $vehicle->driver, debes cambiarlo por la lógica de asignación.
// Ejemplo de función auxiliar para obtener el conductor actual de un vehículo:
private function getCurrentDriver($vehicle)
{
    // Obtiene el último conductor asignado a este vehículo
    $assignment = $vehicle->vehicleAssignments()->latest()->first();
    return $assignment ? $assignment->driver : null; // Asegúrate de tener la relación driver() en VehicleAssignment
}
    }
    // O si quieres todos los conductores:
    // $drivers = $vehicle->drivers;

