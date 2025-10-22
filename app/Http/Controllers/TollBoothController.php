<?php

namespace App\Http\Controllers;

require_once app_path('Libraries/fpdf.php');

use App\Models\TollBooth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TollBoothRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TollBoothController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request): View
     {
         $query = TollBooth::query(); // Iniciar la consulta de casetas de peaje
     
         // Si hay un término de búsqueda
         if ($request->has('search') && $request->input('search') != '') {
             $search = $request->input('search');
             // Filtrar por campos relevantes
             $query->where('name', 'like', "%$search%")
                 ->orWhere('location', 'like', "%$search%")
                 ->orWhere('route_id', 'like', "%$search%")
                    ->orWhere('heavy_vehicle_cost', 'like', "%$search%")
                 ->orWhere('operation_hours', 'like', "%$search%"); 


                 // Puedes añadir más campos si es necesario
         }
     
         $tollBooths = $query->paginate(10); // Cambia el número según la cantidad de resultados por página
     
         return view('toll-booth.index', compact('tollBooths'))
             ->with('i', ($request->input('page', 1) - 1) * $tollBooths->perPage());
     }
     
    


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $tollBooth = new TollBooth();

        return view('toll-booth.create', compact('tollBooth'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TollBoothRequest $request): RedirectResponse
    {
        TollBooth::create($request->validated());

        return Redirect::route('toll-booths.index')
            ->with('success', 'TollBooth created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $tollBooth = TollBooth::find($id);

        return view('toll-booth.show', compact('tollBooth'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $tollBooth = TollBooth::find($id);

        return view('toll-booth.edit', compact('tollBooth'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TollBoothRequest $request, TollBooth $tollBooth): RedirectResponse
    {
        $tollBooth->update($request->validated());

        return Redirect::route('toll-booths.index')
            ->with('success', 'TollBooth updated successfully');
    }

// Eliminado lógico
public function destroy($id)
{
    $tollBooth = \App\Models\TollBooth::findOrFail($id);
    $tollBooth->delete();
    return redirect()->route('toll-booths.index')->with('success', 'Peaje eliminado correctamente.');
}

// Vista de eliminados lógicos
public function trashed()
{
    $tollBooths = \App\Models\TollBooth::onlyTrashed()->paginate(10);
    return view('toll-booth.trashed', compact('tollBooths'));
}

// Restaurar
public function restore($id)
{
    $tollBooth = \App\Models\TollBooth::withTrashed()->findOrFail($id);
    $tollBooth->restore();
    return redirect()->route('toll-booths.trashed')->with('success', 'Peaje restaurado correctamente.');
}

// Eliminado físico
public function forceDelete($id)
{
    $tollBooth = \App\Models\TollBooth::onlyTrashed()->findOrFail($id);
    $tollBooth->forceDelete();
    return redirect()->route('toll-booths.trashed')->with('success', 'Peaje eliminado permanentemente.');
}
    
public function generateReport(Request $request)
{
    $query = TollBooth::query();

    // Aplica el filtro si existe
    if ($request->has('search') && $request->input('search') != '') {
        $search = $request->input('search');
        $query->where('name', 'like', "%$search%")
              ->orWhere('location', 'like', "%$search%")
              ->orWhere('route_id', 'like', "%$search%")
              ->orWhere('heavy_vehicle_cost', 'like', "%$search%")
              ->orWhere('operation_hours', 'like', "%$search%");
    }

    $tollBooths = $query->get();

    $pdf = new \Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Reporte de Casetas de Peaje', 0, 1, 'C');
    $pdf->Ln(5);

    // Encabezado de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, '#', 1);
    $pdf->Cell(40, 10, 'Nombre', 1);
    $pdf->Cell(40, 10, 'Ubicación', 1);
    $pdf->Cell(30, 10, 'Ruta', 1);
    $pdf->Cell(40, 10, 'Costo Vehículo Pesado', 1);
    $pdf->Cell(30, 10, 'Horas Operación', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    $i = 1;
    foreach ($tollBooths as $tollBooth) {
        $pdf->Cell(10, 10, $i++, 1);
        $pdf->Cell(40, 10, utf8_decode($tollBooth->name), 1);
        $pdf->Cell(40, 10, utf8_decode($tollBooth->location), 1);
        $pdf->Cell(30, 10, $tollBooth->route_id, 1);
        $pdf->Cell(40, 10, $tollBooth->heavy_vehicle_cost, 1);
        $pdf->Cell(30, 10, utf8_decode($tollBooth->operation_hours ?? '-'), 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'reporte_casetas_peaje.pdf'); // Descarga directa
    exit;
}
}
