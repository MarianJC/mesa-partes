<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="sidebar-estudiante">
    <!-- Encabezado -->
    <div class="encabezado">
        <img src="{{ asset('images/logoppd.png') }}" alt="Logo del Instituto">
        <h3>IESTP "Pedro P. Díaz"</h3>
    </div>

    <hr>

    <!-- Usuario -->
    <div class="usuario">
        <span><i class="fas fa-user icono-usuario"></i></span>

        <div class="usuario-info">
            <strong>{{ Auth::guard('mesapartes')->user()->nombre }}</strong><br>
            <small>
                Rol:
                @php
                    echo match(Auth::guard('mesapartes')->user()->rol) {
                        'mesa_de_partes' => 'Mesa de Partes',
                        'secretaria_academica' => 'Secretaría Académica',
                        'direccion_academica' => 'Dirección Académica',
                        default => 'Personal',
                    };
                @endphp
            </small>
        </div>
    </div>

    <br>
    <hr>

    <!-- Menú según rol -->
    <nav>
        <ul>
            @php
                $rol = Auth::guard('mesapartes')->user()->rol;
            @endphp

            @if($rol === 'mesa_de_partes')
                <li>
                    <a href="{{ url('/panel-mesapartes') }}"
                        class="{{ request()->is('panel-mesapartes') ? 'activo' : '' }}">
                        <i class="fas fa-inbox"></i> Bandeja de Trámites
                    </a>
                </li>
                <li>
                    <a href="{{ route('mesapartes.historial') }}"
                        class="{{ request()->is('historial-tramites') ? 'activo' : '' }}">
                        <i class="fas fa-history"></i> Historial
                    </a>
                </li>

           @elseif($rol === 'secretaria_academica')
                <li>
                    <a href="{{ url('/panel-secretaria') }}"
                        class="{{ request()->is('panel-secretaria') ? 'activo' : '' }}">
                        <i class="fas fa-folder-open"></i> Trámites Asignados
                    </a>
                </li>
                <li>
                    <a href="{{ route('secretaria.historial') }}"
                        class="{{ request()->is('historial-secretaria') ? 'activo' : '' }}">
                        <i class="fas fa-history"></i> Historial
                    </a>
                </li>

           @elseif($rol === 'direccion_academica')
                <li>
                    <a href="{{ route('panel.direccion') }}"
                    class="{{ request()->routeIs('panel.direccion') ? 'activo' : '' }}">
                        <i class="fas fa-folder-open"></i> Trámites Asignados
                    </a>
                </li>

                <li>
                    <a href="{{ route('direccion.historial') }}"
                    class="{{ request()->is('historial-direccion') ? 'activo' : '' }}">
                        <i class="fas fa-history"></i> Historial
                    </a>
                </li>
            @endif

        </ul>
    </nav>

    <hr>

    <!-- Botón cerrar sesión abajo -->
    <div class="logout">
        <form method="POST" action="{{ route('logout.mesapartes') }}">
            @csrf
            <button type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
        </form>
    </div>
</div>
