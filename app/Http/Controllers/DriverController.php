<?php

namespace App\Http\Controllers;

require_once app_path('Libraries/fpdf.php');

use App\Models\Driver;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\DriverRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Role;



class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */


public function index(Request $request)
{
    $search = $request->input('search');

    $drivers = \App\Models\Driver::with('user')
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('license_number', 'like', "%{$search}%")
                ->orWhere('license_expiration', 'like', "%{$search}%")
                ->orWhere('license_type', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('monthly_driving_hours', 'like', "%{$search}%")
                ->orWhere('safety_score', 'like', "%{$search}%")
                ->orWhere('last_evaluation', 'like', "%{$search}%");
            });
        })
        ->paginate(10);

    return view('driver.index', compact('drivers'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
}

    /**
     * Show the form for creating a new resource.
     */


public function create()
{
    // Busca el rol 'conductor' por nombre
    $driverRole = Role::where('name', 'conductor')->first();

    $users = collect(); // Inicializa una colección vacía

    if ($driverRole) {
        // Carga los usuarios asociados a ese rol
        $users = $driverRole->users;
    }

    $driver = new Driver();
    $url = route('drivers.store'); // <-- Define la URL para crear
    $method = 'POST'; // <-- Define el método para crear

    return view('driver.create', compact('users', 'driver', 'url', 'method')); // <-- Pasa las nuevas variables
}



    // tablas combinadas
    public function combinados(Request $request)
    {
        $query = \App\Models\Driver::with(['user', 'user.role']);

        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('license_number', 'like', "%$search%")
                ->orWhere('license_type', 'like', "%$search%")
                ->orWhereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                })
                ->orWhereHas('user.role', function ($q3) use ($search) {
                    $q3->where('name', 'like', "%$search%");
                });
            });
        }

        $drivers = $query->paginate(10);

        return view('driver.combinados', compact('drivers'))
            ->with('i', ($request->input('page', 1) - 1) * $drivers->perPage());
    }


public function reporteCombinados(Request $request)
{
    $query = \App\Models\Driver::with(['user', 'trips']);

    if ($request->has('search') && $request->input('search') != '') {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('license_number', 'like', "%$search%")
              ->orWhere('license_type', 'like', "%$search%")
              ->orWhereHas('user', function ($q2) use ($search) {
                  $q2->where('name', 'like', "%$search%")
                     ->orWhere('email', 'like', "%$search%");
              });
        });
    }

    $drivers = $query->get();

    $pdf = new \Fpdf();
    $pdf->AddPage('L'); // Horizontal
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 8, utf8_decode('Reporte Conductores - Viajes Realizados'), 0, 1, 'C');
    $pdf->Ln(2);

    // Encabezados
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(35, 7, 'Nombre Usuario', 1);
    $pdf->Cell(45, 7, 'Email', 1);
    $pdf->Cell(18, 7, 'Viajes', 1);
    $pdf->Cell(25, 7, 'Licencia', 1);
    $pdf->Cell(22, 7, 'Tipo', 1);
    $pdf->Cell(18, 7, 'Estado', 1);
    $pdf->Cell(30, 7, 'Vencimiento', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 8);
    foreach ($drivers as $driver) {
        $pdf->Cell(35, 6, utf8_decode($driver->user->name ?? '-'), 1);
        $pdf->Cell(45, 6, utf8_decode($driver->user->email ?? '-'), 1);
        $pdf->Cell(18, 6, $driver->trips->count(), 1, 0, 'C');
        $pdf->Cell(25, 6, utf8_decode($driver->license_number), 1);
        $pdf->Cell(22, 6, utf8_decode($driver->license_type), 1);
        $pdf->Cell(18, 6, utf8_decode($driver->status), 1);
        $pdf->Cell(30, 6, utf8_decode($driver->license_expiration), 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'reporte_conductores_combinados.pdf');
    exit;
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(DriverRequest $request): RedirectResponse
    {
        Driver::create($request->validated());

        return Redirect::route('drivers.index')
            ->with('success', 'Driver created successfully.');
    }

        public function showDeleted()
    {
        $deletedDrivers = Driver::onlyTrashed()->get();
        return view('driver.eliminados', compact('deletedDrivers'));
    }

    // Restaurar conductor eliminado
    public function restore($id)
    {
        $driver = Driver::withTrashed()->findOrFail($id);
        $driver->restore();
        return redirect()->route('drivers.eliminados')->with('success', 'Conductor restaurado con éxito.');
    }

    // Eliminación definitiva
    public function forceDelete($id)
    {
        $driver = Driver::withTrashed()->findOrFail($id);
        $driver->forceDelete();
        return redirect()->route('drivers.eliminados')->with('success', 'Conductor eliminado definitivamente.');
    }
    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $driver = Driver::find($id);

        return view('driver.show', compact('driver'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver) // Si estás editando un conductor existente
{
    // Eager load the user relationship for the driver being edited
    $driver->load('user');

    // Busca el rol 'conductor' por nombre
    $driverRole = Role::where('name', 'conductor')->first();

    $users = collect(); // Inicializa una colección vacía por si no se encuentra el rol

    if ($driverRole) {
        // Carga los usuarios asociados a ese rol
        $users = $driverRole->users; // Asumiendo una relación 'users' en el modelo Role
    }

    $url = route('drivers.update', $driver->id); // <-- Define la URL para editar
    $method = 'PATCH'; // <-- Define el método para editar (o 'PUT')

    // Pasa el driver existente, los usuarios con el rol 'conductor' y las nuevas variables a la vista
    return view('driver.edit', compact('driver', 'users', 'url', 'method')); // <-- Pasa las nuevas variables
}

    /**
     * Update the specified resource in storage.
     */


public function update(Request $request, $id)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'user_name' => 'nullable|string|max:255', // <-- ahora es opcional
        // ...otros campos de driver...
    ]);

    $driver = \App\Models\Driver::findOrFail($id);

    // Actualiza los datos del conductor
    $driver->update($request->only([
        'user_id',
        'license_number',
        'license_expiration',
        'license_type',
        'status',
        'monthly_driving_hours',
        'safety_score',
        'last_evaluation',
    ]));

    // Solo actualiza el nombre si se envió uno nuevo
    if ($driver->user && $request->filled('user_name')) {
        $driver->user->name = $request->input('user_name');
        $driver->user->save();
    }

    return redirect()->route('drivers.index')->with('success', 'Conductor actualizado correctamente.');
}

    public function destroy($id): RedirectResponse
    {
        Driver::find($id)->delete();

        return Redirect::route('drivers.index')
            ->with('success', 'Driver deleted successfully');
    }


public function generateReport(Request $request)
{
    $search = $request->input('search');

    $drivers = \App\Models\Driver::with('user')
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('license_number', 'like', "%{$search}%")
                ->orWhere('license_expiration', 'like', "%{$search}%")
                ->orWhere('license_type', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('monthly_driving_hours', 'like', "%{$search}%")
                ->orWhere('safety_score', 'like', "%{$search}%")
                ->orWhere('last_evaluation', 'like', "%{$search}%");
            });
        })
        ->get();

    $pdf = new \Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Reporte de Conductores', 0, 1, 'C');
    $pdf->Ln(5);

    // Encabezado de la tabla
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, '#', 1);
    $pdf->Cell(40, 10, 'Usuario', 1);
    $pdf->Cell(40, 10, 'Licencia', 1);
    $pdf->Cell(40, 10, 'Tipo', 1);
    $pdf->Cell(30, 10, 'Estado', 1);

    $pdf->Ln();

    $pdf->SetFont('Arial', '', 10);
    $i = 1;
    foreach ($drivers as $driver) {
        $pdf->Cell(10, 10, $i++, 1);
        $pdf->Cell(40, 10, utf8_decode($driver->user->name ?? '-'), 1); // Muestra el nombre
        $pdf->Cell(40, 10, utf8_decode($driver->license_number), 1);
        $pdf->Cell(40, 10, utf8_decode($driver->license_type), 1);
        $pdf->Cell(30, 10, utf8_decode($driver->status), 1);
        $pdf->Ln();
    }

    $pdf->Output('D', 'reporte_conductores.pdf'); // Descarga directa
    exit;
}}
