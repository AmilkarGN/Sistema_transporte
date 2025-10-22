<?php

namespace App\Http\Controllers;

require_once app_path('Libraries/fpdf.php');

use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index(Request $request): View
{
    $query = Role::query(); // Iniciar la consulta de roles

    // Aplicar filtros de búsqueda si se proporciona un término
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where('name', 'like', "%$search%")
            ->orWhere('guard_name', 'like', "%$search%"); // Agrega más campos si es necesario
    }

    // Paginación de resultados
    $roles = $query->paginate(10)->appends($request->query()); // Mantener los parámetros de búsqueda en la paginación

    return view('role.index', compact('roles'))
        ->with('i', ($request->input('page', 1) - 1) * $roles->perPage());
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $permissions = Permission::all();
    $role = null;
    $rolePermissions = [];
    return view('role.create', compact('permissions', 'role', 'rolePermissions'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:roles,name',
        'guard_name' => 'required|string|max:255',
    ]);

    Role::create($request->all());

    return redirect()->route('roles.index')->with('success', 'Rol creado correctamente.');
}

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $role = Role::find($id);

        return view('role.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $role = \Spatie\Permission\Models\Role::findOrFail($id);
    $permissions = \Spatie\Permission\Models\Permission::all();
    $rolePermissions = $role->permissions->pluck('id')->toArray();

    return view('role.edit', compact('role', 'permissions', 'rolePermissions'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        return Redirect::route('roles.index')
            ->with('success', 'Role updated successfully');
    }


public function destroy($id)
{
    $role = Role::findOrFail($id);
    $role->delete();

    return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente.');
}   
// Mostrar roles eliminados
public function showDeleted()
{
    $deletedRoles = Role::onlyTrashed()->get();
    return view('role.eliminados', compact('deletedRoles'));
}

// Restaurar rol eliminado
public function restore($id)
{
    $role = Role::withTrashed()->findOrFail($id);
    $role->restore();
    return redirect()->route('roles.eliminados')->with('success', 'Rol restaurado con éxito.');
}

// Eliminación definitiva
public function forceDelete($id)
{
    $role = Role::withTrashed()->findOrFail($id);
    $role->forceDelete();
    return redirect()->route('roles.eliminados')->with('success', 'Rol eliminado definitivamente.');
}

public function combinados(Request $request)
{
    $query = \App\Models\Role::with(['users.driver']);

    if ($request->has('search') && $request->input('search') != '') {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%");
        })
        ->orWhereHas('users', function ($q2) use ($search) {
            $q2->where('name', 'like', "%$search%")
               ->orWhere('email', 'like', "%$search%")
               ->orWhereHas('driver', function ($q3) use ($search) {
                   $q3->where('license_number', 'like', "%$search%");
               });
        });
    }

    $roles = $query->paginate(10);

    return view('role.combinados', compact('roles'))
        ->with('i', ($request->input('page', 1) - 1) * $roles->perPage());
}


//Reporte de roles combinados
public function reporteCombinados(Request $request)
{
    $query = \App\Models\Role::with(['users.roles']);

    if ($request->has('search') && $request->input('search') != '') {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%");
        })
        ->orWhereHas('users', function ($q2) use ($search) {
            $q2->where('name', 'like', "%$search%")
               ->orWhere('email', 'like', "%$search%")
               ->orWhereHas('roles', function ($q3) use ($search) {
                   $q3->where('name', 'like', "%$search%");
               });
        });
    }

    $roles = $query->get();

    $pdf = new \Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Reporte Combinado Roles-Usuarios', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 10, 'Rol', 1);
    $pdf->Cell(40, 10, 'Usuario', 1);
    $pdf->Cell(60, 10, 'Email', 1);
    $pdf->Cell(50, 10, 'Roles del Usuario', 1);
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 9);
    foreach ($roles as $role) {
        if ($role->users->count() > 0) {
            foreach ($role->users as $user) {
                $rolesUsuario = '';
                if (method_exists($user, 'roles')) {
                    foreach ($user->roles as $userRole) {
                        $rolesUsuario .= $userRole->name . ', ';
                    }
                    $rolesUsuario = rtrim($rolesUsuario, ', ');
                } else {
                    $rolesUsuario = $role->name;
                }
                $pdf->Cell(40, 10, utf8_decode($role->name), 1);
                $pdf->Cell(40, 10, utf8_decode($user->name), 1);
                $pdf->Cell(60, 10, utf8_decode($user->email), 1);
                $pdf->Cell(50, 10, utf8_decode($rolesUsuario), 1);
                $pdf->Ln();
            }
        } else {
            $pdf->Cell(40, 10, utf8_decode($role->name), 1);
            $pdf->Cell(150, 10, 'Sin usuarios asignados', 1, 0, 'C');
            $pdf->Ln();
        }
    }

    $pdf->Output('D', 'reporte_roles_combinados.pdf');
    exit;
}
//reporte de roles
public function generateReport(Request $request)
{
    $query = \App\Models\Role::with(['users']);

    if ($request->has('search') && $request->input('search') != '') {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('guard_name', 'like', "%$search%");
        });
    }

    $roles = $query->get();

    $pdf = new \Fpdf();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Reporte de Roles', 0, 1, 'C');
    $pdf->Ln(5);

    // Encabezados
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(40, 10, 'Rol', 1);
    $pdf->Cell(60, 10, 'Guard Name', 1);
    $pdf->Cell(90, 10, 'Usuarios Asignados', 1);
    $pdf->Ln();

    // Datos
    foreach ($roles as $role) {
        $usuarios = implode(', ', $role->users->pluck('name')->toArray());
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(40, 10, utf8_decode($role->name), 1);
        $pdf->Cell(60, 10, utf8_decode($role->guard_name), 1);
        $pdf->Cell(90, 10, utf8_decode($usuarios), 1);
        $pdf->Ln();
    }

    // Salida del PDF
    $pdf->Output('D', 'reporte_roles.pdf');
    exit;       
}

}