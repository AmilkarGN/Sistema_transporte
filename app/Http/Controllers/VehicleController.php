<?php

namespace App\Http\Controllers;

require_once app_path('Libraries/fpdf.php');

use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\VehicleRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
public function index(Request $request): View
{
    $query = Vehicle::query();

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('brand', 'like', "%$search%")
              ->orWhere('model', 'like', "%$search%")
              ->orWhere('license_plate', 'like', "%$search%")
              ->orWhere('type', 'like', "%$search%")
              ->orWhere('load_capacity', 'like', "%$search%")
              ->orWhere('status', 'like', "%$search%");
        });
    }

    $vehicles = $query->paginate(10)->appends($request->query());

    return view('vehicle.index', compact('vehicles'))
        ->with('i', ($request->input('page', 1) - 1) * $vehicles->perPage());
}

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $vehicle = new Vehicle();

        return view('vehicle.create', compact('vehicle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleRequest $request): RedirectResponse
    {
        Vehicle::create($request->validated());

        return Redirect::route('vehicles.index')
            ->with('success', 'Vehicle created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $vehicle = Vehicle::find($id);

        return view('vehicle.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $vehicle = Vehicle::find($id);

        return view('vehicle.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleRequest $request, Vehicle $vehicle): RedirectResponse
    {
        $vehicle->update($request->validated());

        return Redirect::route('vehicles.index')
            ->with('success', 'Vehicle updated successfully');
    }
public function destroy($id)
{
    $vehicle = \App\Models\Vehicle::findOrFail($id);
    $vehicle->delete(); // Esto hace el soft delete
    return redirect()->route('vehicles.index')->with('success', 'Vehículo eliminado correctamente.');
}
public function trashed()
{
    $vehicles = \App\Models\Vehicle::onlyTrashed()->paginate(10);
    return view('vehicle.trashed', compact('vehicles'));
}
    
// Eliminado físico
public function forceDestroy($id)
{
    $vehicle = \App\Models\Vehicle::withTrashed()->findOrFail($id);
    $vehicle->forceDelete();
    return redirect()->route('vehicles.trashed')->with('success', 'Vehículo eliminado permanentemente.');
}

public function restore($id)
{
    $vehicle = \App\Models\Vehicle::withTrashed()->findOrFail($id);
    $vehicle->restore();
    return redirect()->route('vehicles.trashed')->with('success', 'Vehículo restaurado correctamente.');
}

public function generateReport(Request $request)
{
    $query = Vehicle::query();

    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
           $q->where('brand', 'like', "%$search%")
  ->orWhere('model', 'like', "%$search%")
  ->orWhere('license_plate', 'like', "%$search%")
  ->orWhere('type', 'like', "%$search%")
  ->orWhere('load_capacity', 'like', "%$search%")
  ->orWhere('status', 'like', "%$search%");
        });
    }

    $vehicles = $query->get();

    $pdf = new \Fpdf();
    $pdf->AddPage('L');
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Reporte de Vehiculos', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, '#', 1);
    $pdf->Cell(40, 10, 'Matricula', 1);
    $pdf->Cell(40, 10, 'Marca', 1);
    $pdf->Cell(40, 10, 'Modelo', 1);
    $pdf->Cell(30, 10, 'Tipo', 1);
    $pdf->Cell(30, 10, 'Capacidad', 1);
    $pdf->Cell(30, 10, 'Estado', 1);

    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    $i = 1;
    foreach ($vehicles as $vehicle) {
        $pdf->Cell(10, 10, $i++, 1);
        $pdf->Cell(40, 10, utf8_decode($vehicle->license_plate), 1);
        $pdf->Cell(40, 10, utf8_decode($vehicle->brand), 1);
        $pdf->Cell(40, 10, utf8_decode($vehicle->model), 1);
        $pdf->Cell(30, 10, utf8_decode($vehicle->type), 1);
        $pdf->Cell(30, 10, utf8_decode($vehicle->load_capacity), 1);
        $pdf->Cell(30, 10, utf8_decode($vehicle->status), 1);
      
        $pdf->Ln();
    }

    $pdf->Output('D', 'reporte_vehiculos.pdf');
    exit;}
}
