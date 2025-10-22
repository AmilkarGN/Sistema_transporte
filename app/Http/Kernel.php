<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class CheckRoleOrPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role
     * @param  string|null  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = null, $permission = null)
    {
        // Si se proporciona un rol, verificar si el usuario tiene ese rol
        if ($role && !$request->user()->hasRole($role)) {
            return response()->json(['message' => 'No tienes el rol requerido.'], 403);
        }

        // Si se proporciona un permiso, verificar si el usuario tiene ese permiso
        if ($permission && !$request->user()->can($permission)) {
            return response()->json(['message' => 'No tienes el permiso requerido.'], 403);
        }

        return $next($request);
    }
}

// En el archivo app/Http/Kernel.php
class Kernel extends HttpKernel
{
    // ...existing code...

    protected $routeMiddleware = [
        // ...existing code...
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        // ...existing code...
    ];

    // ...existing code...
}

