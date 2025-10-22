<?php


namespace App\Http\Controllers;
require_once app_path('Libraries/fpdf.php');

use App\Models\Client;
use Illuminate\Http\Request;

use setasign\Fpdf\Fpdf;
class ClientController extends Controller
{
    public function index(Request $request)
{
    $query = Client::query();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('phone', 'like', "%$search%");
        });
    }

    $clients = $query->paginate(10);
    return view('client.index', compact('clients'));
}

    public function create()
{
    // Solo usuarios con rol 'cliente'
    $users = \App\Models\User::whereHas('role', function($q) {
        $q->where('name', 'cliente');
    })->get();

    return view('client.create', compact('users'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email',
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
        ]);

        Client::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Cliente creado correctamente.');
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('client.show', compact('client'));
    }

    public function edit($id)
{
    $client = Client::findOrFail($id);
    $users = \App\Models\User::whereHas('role', function($q) {
        $q->where('name', 'cliente');
    })->get();

    return view('client.edit', compact('client', 'users'));
}

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:clients,email,' . $id,
            'telefono' => 'nullable|string|max:50',
            'direccion' => 'nullable|string|max:255',
        ]);

        $client = Client::findOrFail($id);
        $client->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Cliente eliminado correctamente.');
    }
        public function trashed()
        {
            $clients = Client::onlyTrashed()->paginate(10);
            return view('client.trashed', compact('clients'));
        }

        public function forceDelete($id)
        {
            $client = Client::onlyTrashed()->findOrFail($id);
            $client->forceDelete();
            return redirect()->route('clients.trashed')->with('success', 'Cliente eliminado permanentemente.');
        }
        public function restore($id)
        {
            $client = \App\Models\Client::withTrashed()->findOrFail($id);
            $client->restore();
            return redirect()->route('clients.trashed')->with('success', 'Cliente restaurado correctamente.');
        }

public function report(Request $request)
{
    $query = Client::query();

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('nombre', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('telefono', 'like', "%$search%");
        });
    }

    $clients = $query->get();

    $pdf = new \Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, utf8_decode('Reporte de Clientes'), 0, 1, 'C');
    $pdf->Ln(5);

    // Encabezados de tabla
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 8, '#', 1);
    $pdf->Cell(50, 8, 'Nombre', 1);
    $pdf->Cell(60, 8, 'Email', 1);
    $pdf->Cell(40, 8, 'Teléfono', 1);
    $pdf->Ln();

    // Datos
    $pdf->SetFont('Arial', '', 10);
    foreach ($clients as $i => $client) {
        $pdf->Cell(10, 8, $i + 1, 1);
        $pdf->Cell(50, 8, utf8_decode($client->nombre), 1);
        $pdf->Cell(60, 8, utf8_decode($client->email), 1);
        $pdf->Cell(40, 8, utf8_decode($client->telefono), 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'reporte_clientes.pdf');
    exit;
}
    
}