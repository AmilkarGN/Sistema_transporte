<?php

namespace App\Http\Controllers;

require_once app_path('Libraries/fpdf.php');

use App\Models\Shipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ShipmentRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; // Importar la fachada Auth


class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request): View
{
    $query = Shipment::query(); // Iniciar la consulta de envíos

    // Aplicar filtros de búsqueda si se proporciona un término
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where('type', 'like', "%$search%")
            ->orWhere('origin', 'like', "%$search%")
            ->orWhere('destination', 'like', "%$search%")
            ->orWhere('status', 'like', "%$search%")
            ->orWhere('description', 'like', "%$search%")
            ->orWhere('user_id', 'like', "%$search%");
            // Agrega más campos si es necesario
    }

    // Paginación de resultados
    $shipments = $query->paginate(10)->appends($request->query()); // Mantener los parámetros de búsqueda en la paginación

    return view('shipment.index', compact('shipments'))
        ->with('i', ($request->input('page', 1) - 1) * $shipments->perPage());
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $clients = \App\Models\Client::all();
    return view('shipment.create', compact('clients'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShipmentRequest $request) // Usando el Form Request para validación
    {
        // Obtener los datos validados del Form Request
        $validatedData = $request->validated();

        // Añadir el user_id del usuario autenticado a los datos validados
        // Asegúrate de que el usuario esté autenticado antes de hacer esto
        if (Auth::check()) {
            $validatedData['user_id'] = Auth::id();
        } else {
            // Manejar el caso en que el usuario no está autenticado si es posible
            // Dependiendo de tu lógica de negocio, podrías lanzar un error,
            // redirigir al login, o asignar un user_id por defecto si aplica.
            // Para este ejemplo, asumimos que el usuario debe estar autenticado.
            // Si no lo está, podrías lanzar una excepción o redirigir.
            // throw new \Exception('User not authenticated.');
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para crear un envío.');
        }


        // Crear el envío con los datos validados (ahora incluyendo user_id)
        $shipment = Shipment::create($validatedData);

        // Redireccionar con un mensaje de éxito
        return redirect()->route('shipments.index') // Ajusta la ruta de redirección si es necesario
                         ->with('success', 'Envío creado exitosamente.');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $shipment = \App\Models\Shipment::findOrFail($id);
    return view('shipment.show', compact('shipment'));
}

    /**
     * Show the form for editing the specified resource.
     */
    
public function edit($id): View
{
    $shipment = Shipment::with('client')->findOrFail($id);
    return view('shipment.edit', compact('shipment'));
}

    /**
     * Update the specified resource in storage.
     */

public function update(ShipmentRequest $request, Shipment $shipment) // Usando el Form Request y Route Model Binding
    {
        // Los datos validados ya incluyen origin_lat, origin_lng, etc.
        $validatedData = $request->validated();

        // Actualizar el envío con los datos validados
        $shipment->update($validatedData);

        // Redireccionar con un mensaje de éxito
        return redirect()->route('shipments.index') // Ajusta la ruta de redirección si es necesario
                         ->with('success', 'Envío actualizado exitosamente.');
    }


// Eliminado lógico
public function destroy($id)
{
    $shipment = \App\Models\Shipment::findOrFail($id);
    $shipment->delete();
    return redirect()->route('shipments.index')->with('success', 'Envío eliminado correctamente.');
}

// Vista de eliminados lógicos
public function trashed()
{
    $shipments = \App\Models\Shipment::onlyTrashed()->paginate(10);
    return view('shipment.trashed', compact('shipments'));
}

// Restaurar
public function restore($id)
{
    $shipment = \App\Models\Shipment::withTrashed()->findOrFail($id);
    $shipment->restore();
    return redirect()->route('shipments.trashed')->with('success', 'Envío restaurado correctamente.');
}

// Eliminado físico
public function forceDelete($id)
{
    $shipment = \App\Models\Shipment::onlyTrashed()->findOrFail($id);
    $shipment->forceDelete();
    return redirect()->route('shipments.trashed')->with('success', 'Envío eliminado permanentemente.');
}
    
public function generateReport(Request $request)
{
    $query = Shipment::query();

    // Aplica el filtro si existe
    if ($request->has('search') && $request->input('search') != '') {
        $search = $request->input('search');
        $query->where('type', 'like', "%$search%")
              ->orWhere('status', 'like', "%$search%")
              ->orWhere('origin', 'like', "%$search%")
              ->orWhere('destination', 'like', "%$search%");
    }

    $shipments = $query->get();

    $pdf = new \Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Reporte de Envíos', 0, 1, 'C');
    $pdf->Ln(5);

    // Encabezado de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, '#', 1);
    $pdf->Cell(40, 10, 'Tipo', 1);
    $pdf->Cell(40, 10, 'Estado', 1);
    $pdf->Cell(40, 10, 'Origen', 1);
    $pdf->Cell(40, 10, 'Destino', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    $i = 1;
    foreach ($shipments as $shipment) {
        $pdf->Cell(10, 10, $i++, 1);
        $pdf->Cell(40, 10, utf8_decode($shipment->type), 1);
        $pdf->Cell(40, 10, utf8_decode($shipment->status), 1);
        $pdf->Cell(40, 10, utf8_decode($shipment->origin), 1);
        $pdf->Cell(40, 10, utf8_decode($shipment->destination), 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'reporte_envios.pdf'); // Descarga directa
    exit;
}
}
