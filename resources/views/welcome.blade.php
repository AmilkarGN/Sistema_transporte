<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Transporte</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .hero {
            background: url('{{ asset('vendor/adminlte/dist/img/Transporte1.jpg') }}') no-repeat center center;
            background-size: cover;
            height: 400px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero h1, .hero p {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8); /* Borde negro */
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }
        .hero p {
            font-size: 1.2rem;
        }
        .carousel-item img {
            height: 400px; /* Altura fija para las imágenes del slider */
            object-fit: cover; /* Ajusta la imagen para que se vea bien */
        }
    </style>
</head>
<body class="bg-light text-dark">

    <!-- Header -->
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <h1 class="h3">Sistema de Transporte</h1>
            <nav>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-light">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-light">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div>
            <h1>Bienvenido al Sistema de Transporte</h1>
            <p>Gestión eficiente de envíos, rutas y conductores.</p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">¿Qué puedes hacer?</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <i class="fas fa-truck fa-3x text-primary mb-3"></i>
                    <h4>Gestión de Envíos</h4>
                    <p>Administra tus envíos de manera eficiente y en tiempo real.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-route fa-3x text-success mb-3"></i>
                    <h4>Optimización de Rutas</h4>
                    <p>Planifica rutas óptimas para ahorrar tiempo y costos.</p>
                </div>
                <div class="col-md-4">
                    <i class="fas fa-users fa-3x text-warning mb-3"></i>
                    <h4>Gestión de Conductores</h4>
                    <p>Supervisa y organiza a tus conductores fácilmente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Slider Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="text-center mb-4">Galería</h2>
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('vendor/adminlte/dist/img/SliderEnvios.jpg') }}" class="d-block w-100" alt="Envíos">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('vendor/adminlte/dist/img/SliderRutas.jpg') }}" class="d-block w-100" alt="Rutas">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('vendor/adminlte/dist/img/SliderConductor.jpg') }}" class="d-block w-100" alt="Conductores">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} Sistema de Transporte. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>