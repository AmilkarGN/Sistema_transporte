<?php

namespace App\Http\Controllers;

require_once app_path('Libraries/fpdf.php');

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Role;
use App\Models\Client;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query();
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%");
        }
        $users = $query->paginate(10);
        return view('user.index', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * $users->perPage());
    }

    public function showDeleted()
    {
        $deletedUsers = User::onlyTrashed()->get();
        return view('user.eliminados', compact('deletedUsers'));
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('users.deleted')->with('success', 'Usuario restaurado con éxito.');
    }

    public function create()
    {
        $roles = Role::all();
        $user = null; // <-- Añadido para evitar el error de variable indefinida
        return view('user.create', compact('roles', 'user'));
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['password'] = bcrypt($validated['password']);

        if ($request->hasFile('profile_photo')) {
            $image = $request->file('profile_photo');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/profile_photos'), $imageName);
            $validated['profile_photo'] = 'uploads/profile_photos/' . $imageName;
        }

        // Elimina 'role_id' del array si llega por el formulario
        unset($validated['role_id']);

        $user = User::create($validated);

        // Asigna el rol usando Spatie
        if ($request->has('role')) {
            $user->syncRoles([$request->input('role')]);
        }

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function usuariosConductoresRoles(Request $request)
    {
        // Si quieres mostrar los roles en una tabla de roles, usa directamente el modelo Role
        $roles = \Spatie\Permission\Models\Role::with('users')->get();

        // Si necesitas mostrar usuarios con cada rol, puedes pasar ambos a la vista
        // $usuarios = User::with(['driver', 'roles'])->paginate(10);

        return view('role.index', compact('roles'));
    }

    public function reporteCombinados(Request $request)
    {
        // CORREGIDO: Elimina cualquier uso de 'role_id' y usa Spatie para filtrar por roles
        $query = User::with(['driver', 'roles']); // Cambia 'role' por 'roles'

        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhereHas('driver', function ($q2) use ($search) {
                        $q2->where('license_number', 'like', "%$search%");
                    })
                    ->orWhereHas('roles', function ($q3) use ($search) {
                        $q3->where('name', 'like', "%$search%");
                    });
            });
        }

        // Si necesitas filtrar por roles específicos, usa:
        // $query->role(['admin', 'gerente', 'cliente', 'conductor']);

        $usuarios = $query->get();

        $pdf = new \Fpdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Reporte Combinado Usuarios-Conductores-Roles', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, 'Nombre', 1);
        $pdf->Cell(50, 10, 'Email', 1);
        $pdf->Cell(30, 10, 'Rol', 1);
        $pdf->Cell(30, 10, 'Licencia', 1);
        $pdf->Cell(30, 10, 'Tipo Licencia', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 9);
        foreach ($usuarios as $usuario) {
            $pdf->Cell(40, 10, utf8_decode($usuario->name), 1);
            $pdf->Cell(50, 10, utf8_decode($usuario->email), 1);
            // Mostrar todos los roles separados por coma
            $pdf->Cell(30, 10, utf8_decode($usuario->roles->pluck('name')->implode(', ') ?: '-'), 1);
            $pdf->Cell(30, 10, utf8_decode($usuario->driver->license_number ?? '-'), 1);
            $pdf->Cell(30, 10, utf8_decode($usuario->driver->license_type ?? '-'), 1);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_combinados.pdf');
        exit;
    }

    public function show($id): View
    {
        $user = User::find($id);
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.form', compact('user', 'roles'));
    }

    public function editRol($id): View
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('user.editRol', compact('user', 'roles'));
    }

    public function update(UserRequest $request, User $user)
    {
        $validated = $request->validated();

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        unset($validated['role_id']);

        $user->update($validated);

        // Asigna el rol solo si se seleccionó uno
        if ($request->filled('role')) {
            $user->syncRoles([$request->input('role')]);
        } else {
            // Si no se selecciona ningún rol, elimina todos los roles del usuario
            $user->syncRoles([]);
        }

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('users.deleted')->with('success', 'Usuario eliminado definitivamente.');
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::find($id);
        $user->deleted_by = auth()->id();
        $user->save();
        $user->delete();
        return Redirect::route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function generateReport(Request $request)
    {
        $query = User::query();
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('address', 'like', "%$search%");
            });
        }
        $users = $query->get();

        $pdf = new \Fpdf('L', 'mm', 'A4'); // Horizontal para más espacio
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Reporte de Usuarios', 0, 1, 'C');
        $pdf->Ln(5);

        $pdf->SetFont('Arial', 'B', 10);
        // Ajusta el ancho de las celdas para que no choquen los textos
        $pdf->Cell(10, 8, '#', 1);
        $pdf->Cell(40, 8, 'Nombre', 1);
        $pdf->Cell(60, 8, 'Email', 1);
        $pdf->Cell(30, 8, 'Telefono', 1);
        $pdf->Cell(70, 8, 'Direccion', 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 9);
        $i = 1;
        foreach ($users as $user) {
            $pdf->Cell(10, 8, $i++, 1);
            $pdf->Cell(40, 8, utf8_decode($user->name), 1);
            $pdf->Cell(60, 8, utf8_decode($user->email), 1);
            $pdf->Cell(30, 8, utf8_decode($user->phone ?? '-'), 1);
            // Usa MultiCell para dirección si es muy larga
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $pdf->MultiCell(70, 8, utf8_decode($user->address ?? '-'), 1);
            $pdf->SetXY($x + 70, $y);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_usuarios.pdf');
        exit;
    }

    public function perfil()
    {
        $user = Auth::user();
        return view('user.perfil', compact('user'));
    }
}