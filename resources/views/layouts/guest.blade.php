<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistema de Transporte') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Estilos personalizados -->
        <style>
            /* Fondo dinámico */
            body {
                background: linear-gradient(135deg, #4facfe, #00f2fe); /* Colores más frescos */
                animation: gradient 6s ease infinite;
                background-size: 400% 400%;
                color: #ffffff; /* Texto blanco para contraste */
            }

            @keyframes gradient {
                0% { background-position: 0% 50%; }
                50% { background-position: 100% 50%; }
                100% { background-position: 0% 50%; }
            }

            /* Movimiento del logo */
            .logo {
                animation: move 4s infinite alternate ease-in-out;
                width: 180px; /* Tamaño más grande */
                height: 180px; /* Tamaño más grande */
            }

            @keyframes move {
                0% { transform: translateX(0); }
                100% { transform: translateX(50px); } /* Movimiento más amplio */
            }

            /* Contenedor principal */
            .container {
                background: rgba(255, 255, 255, 0.95); /* Fondo blanco más opaco */
                color: #1a202c; /* Texto más oscuro */
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15); /* Sombra más pronunciada */
                border-radius: 12px; /* Bordes más redondeados */
            }

            /* Estilo para etiquetas de texto */
            label {
                color: #1a202c; /* Texto oscuro para mejor visibilidad */
                font-weight: 600; /* Peso más destacado */
                font-size: 1rem; /* Tamaño de fuente más grande */
            }

            /* Estilo para los campos de entrada */
            input {
                border: 1px solid #ccc; /* Borde gris claro */
                border-radius: 8px; /* Bordes redondeados */
                padding: 10px;
                font-size: 1rem;
                color: #333333; /* Texto oscuro */
            }

            input:focus {
                border-color: #4facfe; /* Color de borde al enfocar */
                outline: none;
                box-shadow: 0 0 5px rgba(79, 172, 254, 0.5); /* Sombra al enfocar */
            }

            /* Footer */
            footer {
                color: #ffffff; /* Texto blanco */
                font-size: 0.9rem;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/">
                    <img src="{{ asset('vendor/adminlte/dist/img/Logo1.png') }}" alt="Sistema de Transporte" class="logo">
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 container">
                <h1 class="text-center text-2xl font-bold text-gray-800 mb-4">Bienvenido al Sistema de Transporte</h1>
                {{ $slot }}
            </div>

            <footer class="mt-6 text-center">
                <p>&copy; {{ date('Y') }} Sistema de Transporte. Todos los derechos reservados.</p>
            </footer>
        </div>
    </body>
</html>