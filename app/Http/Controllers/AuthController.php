<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validar los datos de entrada
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Intentar autenticar al usuario
        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            // Guardar el rol en la sesión (asegúrate que $user->role existe y tiene el nombre correcto)
            session(['role_id' => $user->role_id]);
            session(['role_name' => $user->role ? $user->role->name : null]);

            // Redirigir o retornar respuesta
            return redirect()->intended('/inicio');
        } else {
            // Si falla la autenticación
            return back()->withErrors([
                'email' => 'Las credenciales no son válidas.',
            ]);
        }
    }

    public function logout(Request $request)
    {
        // Eliminar usuario y rol de la sesión
        $request->session()->forget(['user_id', 'role_id', 'role_name']);

        return redirect('/login');
    }
}