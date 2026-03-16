<?php

namespace App\Http\Controllers\Auth;

use App\Mail\TwoFactorCodeMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // app/Http/Controllers/Auth/AuthenticatedSessionController.php

public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $user = Auth::user();
    $userIp = $request->ip();

    // 1. Verificar si la IP ya es segura
    $isSafe = $user->safeDevices()->where('ip_address', $userIp)->exists();

    if ($isSafe) {
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    // 2. Si no es segura, preparar el 2FA
    $code = rand(100000, 999999);
    $user->update([
        'two_factor_code' => $code,
        'two_factor_expires_at' => now()->addMinutes(15),
    ]);

    // IMPORTANTE: Guardar en sesión si el usuario marcó el checkbox
    session(['remember_device' => $request->has('remember_device')]);

    // Enviar correo
    Mail::to($user->email)->send(new \App\Mail\TwoFactorCodeMail($code));

    Auth::logout();
    session(['2fa_user_id' => $user->id]);

    return redirect()->route('2fa.index');
}
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
