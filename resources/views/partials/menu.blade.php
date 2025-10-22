{{-- ...existing code... --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/inicio') }}">Sistema Transporte</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @php $role = session('role_name'); @endphp
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/inicio') }}">Inicio</a>
                </li>
                @if($role === 'Admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/usuarios') }}">Gestionar Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/reportes') }}">Reportes</a>
                    </li>
                @endif
                @if($role === 'Conductor')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/mis-viajes') }}">Mis Viajes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/perfil-conductor') }}">Mi Perfil</a>
                    </li>
                @endif
                @if($role === 'Cliente')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/reservar') }}">Realizar Reserva</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/mis-cargas') }}">Mis Cargas</a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ url('/logout') }}">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
{{-- ...existing code... --}}