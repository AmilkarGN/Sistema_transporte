<?php

namespace App\Http\Controllers;

require_once app_path('Libraries/fpdf.php');

use App\Models\Route;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RouteRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
public function index()
{
    $routes = Route::paginate(); // O Route::all(), dependiendo de si quieres paginación
    return view('route.index', compact('routes'));
}






    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $route = new Route();

        return view('route.create', compact('route'));
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(RouteRequest $request): RedirectResponse
{
    Route::create($request->validated());

    return Redirect::route('routes.index')
        ->with('success', 'Route created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(Route $route)
{
    return view('route.show', compact('route'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $route = Route::find($id);

        return view('route.edit', compact('route'));
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(RouteRequest $request, Route $route): RedirectResponse
    {
        $route->update($request->validated());

        return Redirect::route('routes.index')
            ->with('success', 'Route updated successfully');
    }
    public function destroy($id): RedirectResponse
    {
        Route::find($id)->delete();

        return Redirect::route('routes.index')
            ->with('success', 'Route deleted successfully');
    }
        public function trashed()
    {
        $routes = \App\Models\Route::onlyTrashed()->paginate(10);
        return view('route.trashed', compact('routes'));
    }

    public function forceDelete($id)
    {
        $route = \App\Models\Route::onlyTrashed()->findOrFail($id);
        $route->forceDelete();
        return redirect()->route('routes.trashed')->with('success', 'Ruta eliminada permanentemente.');
    }

    public function restore($id)
    {
        $route = \App\Models\Route::withTrashed()->findOrFail($id);
        $route->restore();
        return redirect()->route('routes.trashed')->with('success', 'Ruta restaurada correctamente.');
    }
    
public function report(Request $request)
{
    $query = \App\Models\Route::query();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('origin', 'like', "%$search%")
              ->orWhere('destination', 'like', "%$search%");
        });
    }

    $routes = $query->get();

    $pdf = new \Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, utf8_decode('Reporte de Rutas'), 0, 1, 'C');
    $pdf->Ln(5);

    // Encabezados de tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 8, '#', 1);
    $pdf->Cell(40, 8, 'Nombre', 1);
    $pdf->Cell(40, 8, 'Origen', 1);
    $pdf->Cell(40, 8, 'Destino', 1);
    $pdf->Cell(30, 8, 'Distancia (Km)', 1);
    $pdf->Ln();

    // Datos
    $pdf->SetFont('Arial', '', 10);
    foreach ($routes as $i => $route) {
        $pdf->Cell(10, 8, $i + 1, 1);
        $pdf->Cell(40, 8, utf8_decode($route->name), 1);
        $pdf->Cell(40, 8, utf8_decode($route->origin), 1);
        $pdf->Cell(40, 8, utf8_decode($route->destination), 1);
        $pdf->Cell(30, 8, $route->distance_km, 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'reporte_rutas.pdf');
    exit;
}
}
