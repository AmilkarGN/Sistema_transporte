<?php

namespace App\Http\Controllers;
require_once app_path('Libraries/fpdf.php');
use Illuminate\Http\Request;
use App\Models\VehicleAssignment;

class VehicleAssignmentController extends Controller

{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $query = VehicleAssignment::with(['driver.user', 'vehicle']);

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereHas('driver.user', function($qu) use ($search) {
                $qu->where('name', 'like', "%$search%");
            })
            ->orWhereHas('vehicle', function($qu) use ($search) {
                $qu->where('license_plate', 'like', "%$search%")
                   ->orWhere('brand', 'like', "%$search%")
                   ->orWhere('model', 'like', "%$search%");
            })
            ->orWhere('assigned_at', 'like', "%$search%");
        });
    }

    $assignments = $query->paginate(10);
    return view('vehicle_assignment.index', compact('assignments'));
}

public function show($id)
{
    $assignment = \App\Models\VehicleAssignment::with(['driver.user', 'vehicle'])->findOrFail($id);
    return view('vehicle_assignment.show', compact('assignment'));
}
public function create()
{
    $drivers = \App\Models\Driver::with('user')->get();
    $vehicles = \App\Models\Vehicle::all();
    return view('vehicle_assignment.create', compact('drivers', 'vehicles'));
}

    public function store(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'assigned_at' => 'nullable|date',
        ]);
        \App\Models\VehicleAssignment::create($request->all());
        return redirect()->route('vehicle-assignments.index')->with('success', 'Asignación creada correctamente.');
    }

    public function edit($id)
{
    $assignment = \App\Models\VehicleAssignment::findOrFail($id);
    $drivers = \App\Models\Driver::with('user')->get();
    $vehicles = \App\Models\Vehicle::all();
    return view('vehicle_assignment.edit', compact('assignment', 'drivers', 'vehicles'));
}
    public function update(Request $request, $id)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'assigned_at' => 'nullable|date',
        ]);
        $assignment = \App\Models\VehicleAssignment::findOrFail($id);
        $assignment->update($request->all());
        return redirect()->route('vehicle-assignments.index')->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $assignment = \App\Models\VehicleAssignment::findOrFail($id);
        $assignment->delete();
        return redirect()->route('vehicle-assignments.index')->with('success', 'Asignación eliminada correctamente.');
    }
    public function trashed()
{
    $assignments = VehicleAssignment::onlyTrashed()->with(['driver.user', 'vehicle'])->paginate(10);
    return view('vehicle_assignment.trashed', compact('assignments'));
}

// Eliminado físico
public function forceDelete($id)
{
    $assignment = VehicleAssignment::onlyTrashed()->findOrFail($id);
    $assignment->forceDelete();
    return redirect()->route('vehicle-assignments.trashed')->with('success', 'Asignación eliminada permanentemente.');
}
public function restore($id)
{
    $assignment = \App\Models\VehicleAssignment::withTrashed()->findOrFail($id);
    $assignment->restore();
    return redirect()->route('vehicle-assignments.trashed')->with('success', 'Asignación restaurada correctamente.');
}
public function report(Request $request)
{
    $query = VehicleAssignment::with(['driver.user', 'vehicle']);

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereHas('driver.user', function($qu) use ($search) {
                $qu->where('name', 'like', "%$search%");
            })
            ->orWhereHas('vehicle', function($qu) use ($search) {
                $qu->where('license_plate', 'like', "%$search%")
                   ->orWhere('brand', 'like', "%$search%")
                   ->orWhere('model', 'like', "%$search%");
            })
            ->orWhere('assigned_at', 'like', "%$search%");
        });
    }

    $assignments = $query->get();

    $pdf = new \Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, utf8_decode('Reporte de Asignaciones de Vehiculos'), 0, 1, 'C');
    $pdf->Ln(5);

    // Encabezados
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(50, 8, 'Conductor', 1);
    $pdf->Cell(40, 8, 'Vehiculo', 1);
    $pdf->Cell(40, 8, 'Placa', 1);
    $pdf->Cell(40, 8, 'Fecha Asignacion', 1);
    $pdf->Ln();

    // Datos
    $pdf->SetFont('Arial', '', 10);
    foreach ($assignments as $assignment) {
        $pdf->Cell(50, 8, utf8_decode(optional($assignment->driver->user)->name ?? '-'), 1);
        $pdf->Cell(40, 8, utf8_decode($assignment->vehicle->brand ?? '-'), 1);
        $pdf->Cell(40, 8, utf8_decode($assignment->vehicle->license_plate ?? '-'), 1);
        $pdf->Cell(40, 8, utf8_decode($assignment->assigned_at ?? '-'), 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'reporte_asignaciones_vehiculos.pdf');
    exit;
}}