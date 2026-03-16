<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TwoFactorController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (!session()->has('2fa_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.two-factor');
    }

    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'code' => ['required', 'numeric'],
    ]);

    $userId = session('2fa_user_id');
    $user = User::findOrFail($userId);

    // Validar código y tiempo de expiración
    if ($request->code == $user->two_factor_code && now()->lt($user->two_factor_expires_at)) {
        
        Auth::login($user);

        // LEER EL CHECKBOX DIRECTAMENTE DEL FORMULARIO ACTUAL
        if ($request->has('remember_device')) {
            \App\Models\UserDevice::create([
                'user_id' => $user->id,
                'ip_address' => $request->ip(),
            ]);
        }

        // Limpiar datos
        $user->update(['two_factor_code' => null, 'two_factor_expires_at' => null]);
        session()->forget('2fa_user_id');
        session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    return back()->withErrors(['code' => 'El código es incorrecto o ha expirado.']);
}
}