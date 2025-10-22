<?php

namespace App\Http\Controllers;

require_once app_path('Libraries/fpdf.php');

use App\Models\ShipmentAssignment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ShipmentAssignmentRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Driver; // Asegúrate de importar el modelo Driver
use App\Models\VehicleAssignment; // Asume que tienes este modelo


class ShipmentAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request)
{
    // Asegúrate de cargar todas las relaciones necesarias y que existan datos relacionados
    $shipmentAssignments = \App\Models\ShipmentAssignment::with([
        'shipment.route',
        'driver.user',
        'vehicle',
        'route'
    ])->paginate(10);

    // Si sigues viendo guiones, revisa que las relaciones estén bien definidas en el modelo ShipmentAssignment:
    // public function shipment() { return $this->belongsTo(Shipment::class); }
    // public function driver() { return $this->belongsTo(Driver::class); }
    // public function vehicle() { return $this->belongsTo(Vehicle::class); }
    // public function route() { return $this->belongsTo(Route::class); }

    // También asegúrate de que los IDs en la base de datos no sean nulos y correspondan a registros existentes.

    return view('shipment_assignment.index', compact('shipmentAssignments'))
        ->with('i', ($request->input('page', 1) - 1) * $shipmentAssignments->perPage());
}
    /**
     * Show the form for creating a new resource.
     */
   public function create()
{
    // Recuperar datos para los selectores en el formulario
    $shipments = \App\Models\Shipment::all(); // Asegúrate de importar el modelo Shipment
    $drivers = \App\Models\Driver::with('user')->get(); // Asegúrate de importar el modelo Driver y cargar la relación user
    $vehicles = \App\Models\Vehicle::all(); // Asegúrate de importar el modelo Vehicle
    $routes = \App\Models\Route::all(); // Asegúrate de importar el modelo Route

    $shipmentAssignment = new \App\Models\ShipmentAssignment(); // Instancia vacía para el formulario

    // Pasar las variables a la vista
    return view('shipment_assignment.create', compact('shipmentAssignment', 'shipments', 'drivers', 'vehicles', 'routes'));
}

public function getVehicleByDriver(Driver $driver) // Usando Route Model Binding
    {
        // Buscar la asignación de vehículo activa para este conductor
        // Asume que VehicleAssignment tiene relaciones 'driver' y 'vehicle'
        // y quizás un campo 'status' o 'end_date' para determinar si está activa.
        // Ajusta la lógica de búsqueda según tu modelo VehicleAssignment.
        $vehicleAssignment = VehicleAssignment::where('driver_id', $driver->id)
                                            // ->where('status', 'active') // Ejemplo si tienes un estado
                                            // ->whereNull('end_date') // Ejemplo si usas fechas de fin
                                            ->with('vehicle') // Cargar la relación vehicle
                                            ->first(); // Obtener la primera asignación activa

        // Retornar el vehículo asociado (si existe) como respuesta JSON
        // Si no se encontró una asignación activa, $vehicleAssignment será null
        return response()->json([
            'vehicle' => $vehicleAssignment ? $vehicleAssignment->vehicle : null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShipmentAssignmentRequest $request): RedirectResponse
    {
        ShipmentAssignment::create($request->validated());

        return Redirect::route('shipment-assignments.index')
            ->with('success', 'ShipmentAssignment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $shipmentAssignment = ShipmentAssignment::find($id);

        return view('shipment_assignment.show', compact('shipmentAssignment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\ShipmentAssignment $shipmentAssignment)
{
     // Recuperar datos para los selectores en el formulario
    $shipments = \App\Models\Shipment::all(); // Asegúrate de importar el modelo Shipment
    $drivers = \App\Models\Driver::with('user')->get(); // Asegúrate de importar el modelo Driver y cargar la relación user
    $vehicles = \App\Models\Vehicle::all(); // Asegúrate de importar el modelo Vehicle
    $routes = \App\Models\Route::all(); // Asegúrate de importar el modelo Route

    // Pasar las variables a la vista
    return view('shipment_assignment.edit', compact('shipmentAssignment', 'shipments', 'drivers', 'vehicles', 'routes'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(ShipmentAssignmentRequest $request, ShipmentAssignment $shipmentAssignment): RedirectResponse
    {
        $shipmentAssignment->update($request->validated());

        return Redirect::route('shipment-assignments.index')
            ->with('success', 'ShipmentAssignment updated successfully');
    }


// Eliminado lógico
public function destroy($id)
{
    $assignment = \App\Models\ShipmentAssignment::findOrFail($id);
    $assignment->delete();
    return redirect()->route('shipment-assignments.index')->with('success', 'Asignación eliminada correctamente.');
}

// Vista de eliminados lógicos
public function trashed()
{
    $assignments = \App\Models\ShipmentAssignment::onlyTrashed()->paginate(10);
    return view('shipment_assignment.trashed', compact('assignments'));
}

// Restaurar
public function restore($id)
{
    $assignment = \App\Models\ShipmentAssignment::withTrashed()->findOrFail($id);
    $assignment->restore();
    return redirect()->route('shipment-assignments.trashed')->with('success', 'Asignación restaurada correctamente.');
}

// Eliminado físico
public function forceDelete($id)
{
    $assignment = \App\Models\ShipmentAssignment::onlyTrashed()->findOrFail($id);
    $assignment->forceDelete();
    return redirect()->route('shipment-assignments.trashed')->with('success', 'Asignación eliminada permanentemente.');
}
    
public function generateReport(Request $request)
{
    $query = ShipmentAssignment::query();

    // Aplica el filtro si existe
    if ($request->has('search') && $request->input('search') != '') {
        $search = $request->input('search');
        $query->where('shipment_id', 'like', "%$search%")
              ->orWhere('status', 'like', "%$search%")
              ->orWhere('notes', 'like', "%$search%")
              ->orWhere('delivery_date', 'like', "%$search%");
    }

    $shipmentAssignments = $query->get();

    $pdf = new \Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Reporte de Asignaciones de Envíos', 0, 1, 'C');
    $pdf->Ln(5);

    // Encabezado de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, '#', 1);
    $pdf->Cell(30, 10, 'Trip ID', 1);
    $pdf->Cell(30, 10, 'Shipment ID', 1);
    $pdf->Cell(30, 10, 'Estado', 1);
    $pdf->Cell(40, 10, 'Fecha Asignación', 1);
    $pdf->Cell(40, 10, 'Fecha Entrega', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    $i = 1;
    foreach ($shipmentAssignments as $assignment) {
        $pdf->Cell(10, 10, $i++, 1);
        $pdf->Cell(30, 10, utf8_decode($assignment->trip_id), 1);
        $pdf->Cell(30, 10, utf8_decode($assignment->shipment_id), 1);
        $pdf->Cell(30, 10, utf8_decode($assignment->status), 1);
        $pdf->Cell(40, 10, utf8_decode($assignment->assignment_date), 1);
        $pdf->Cell(40, 10, utf8_decode($assignment->delivery_date ?? '-'), 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'reporte_asignaciones_envios.pdf'); // Descarga directa
    exit;
}
}