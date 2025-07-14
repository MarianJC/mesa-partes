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
        <span><i class="fas fa-user-shield icono-usuario"></i></span>
        <div class="usuario-info">
            <strong>{{ Auth::guard('mesapartes')->user()->nombre }}</strong><br>
            <small>Rol: Administrador</small>
        </div>
    </div>

    <br>
    <hr>

    <!-- Menú -->
    <nav>
        <ul>
            <li>
                {{-- @if (Route::has('admin.dashboard')) --}}
                <a href="{{ route('admin.panel.index') }}"
                    class="{{ request()->routeIs('admin.panel.index') ? 'activo' : '' }}">
                    <i class="fas fa-chart-line"></i> Panel General
                </a>

                {{-- @endif --}}
            </li>
            <li>
                {{-- @if (Route::has('admin.estudiantes.index')) --}}
                <a href="{{ route('admin.estudiantes.index') }}"
                   class="{{ request()->is('admin/estudiantes*') ? 'activo' : '' }}">
                   <i class="fas fa-user-graduate"></i> Estudiantes
                </a>
                {{-- @endif --}}
            </li>
            <li>
                {{-- @if (Route::has('admin.personal.index')) --}}
                <a href="{{ route('admin.personales.index') }}"
                    class="{{ request()->is('admin/personales*') ? 'activo' : '' }}">
                    <i class="fas fa-users-cog"></i> Personal
                </a>
                {{-- @endif --}}
            </li>
            <li>
                {{-- @if (Route::has('admin.tramites.index')) --}}
                <a href="{{ route('admin.tramites.index') }}"
                   class="{{ request()->is('admin/tramites*') ? 'activo' : '' }}">
                   <i class="fas fa-file-alt"></i> Trámites
                </a>
                {{-- @endif --}}
            </li>
          
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
