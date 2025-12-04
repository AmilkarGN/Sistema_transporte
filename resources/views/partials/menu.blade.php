<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/inicio') }}">Sistema Transporte</a>
        <!-- ... botón toggler ... -->
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/inicio') }}">Inicio</a>
                </li>

                {{-- EN LUGAR DE: @if($role === 'Admin') --}}
                {{-- USA ESTO (Verifica el permiso directamente de la BD): --}}
                
                @can('Ver Boton Usuarios')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/users') }}">Gestionar Usuarios</a>
                    </li>
                @endcan

                @can('Ver Boton Roles')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/roles') }}">Roles</a>
                    </li>
                @endcan

                @can('Ver Boton Conductores')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/drivers') }}">Conductores</a>
                    </li>
                @endcan

                {{-- Ejemplo para Conductor --}}
                @role('Conductor')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/mis-viajes') }}">Mis Viajes</a>
                    </li>
                @endrole

                <li class="nav-item">
                    {{-- Usa un formulario POST para logout por seguridad, no un GET --}}
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="nav-link text-danger btn btn-link" style="text-decoration: none;">
                            Cerrar Sesión
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>