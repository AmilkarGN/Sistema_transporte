<?php
// ...existing code...

class AuthController {
    // ...existing code...

    public function register() {
        // ...existing code...

        // Al registrar un usuario, asigna el rol correspondiente
        if ($tipo_usuario == 'admin' || $tipo_usuario == 'conductor' || $tipo_usuario == 'cliente') {
            $usuario->rol = $tipo_usuario;
        } else {
            $usuario->rol = 'cliente';
        }

        // ...existing code...
    }

    public function login() {
        // ...existing code...

        // Al iniciar sesión, guarda el rol en la sesión
        $_SESSION['rol'] = $usuario->rol;

        // ...existing code...
    }

    // ...existing code...
}

// ...existing code...
?>