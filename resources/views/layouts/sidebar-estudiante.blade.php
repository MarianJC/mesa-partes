<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="sidebar-estudiante">
    <!-- Encabezado -->
    <div class="encabezado" style="text-align: center;">
        <img src="{{ asset('images/logoppd.png') }}" alt="Logo del Instituto" width="80">
        <h3>IESTP "Pedro P. Díaz"</h3>
    </div>

    <hr>

    <!-- Usuario -->
    <div class="usuario">
        <span><i class="fas fa-user icono-usuario"></i></span>

        <div class="usuario-info">
            <strong>{{ Auth::guard('estudiante')->user()->nombre }}</strong><br>
            <small>{{ Auth::guard('estudiante')->user()->especialidad }}</small>
        </div>
    </div>

    <br>
    <hr>

    <!-- Menú -->

    @php
    $notiNuevas = \App\Models\Notificacion::where('estudiante_id', Auth::guard('estudiante')->id())
        ->where('leido', false)
        ->count();
@endphp
    <nav>
        <ul>
            <li>
                <a href="{{ url('/panel-estudiante') }}"
                class="{{ request()->is('panel-estudiante') ? 'activo' : '' }}">
                <i class="fas fa-home"></i> Inicio
                </a>
            </li>
            <li>
                <a href="{{ url('/tramites-enviados') }}"
                class="{{ request()->is('tramites-enviados') ? 'activo' : '' }}">
                <i class="fas fa-folder-open"></i> Trámites Enviados
                </a>
            </li>

<li>
    <a href="{{ url('/notificaciones') }}"
       class="{{ request()->is('notificaciones') ? 'activo' : '' }}">
        <i class="fas fa-bell"></i> Notificaciones
        @if($notiNuevas > 0)
            <span class="noti-badge">{{ $notiNuevas }}</span>
        @endif
    </a>
</li>
        </ul>
    </nav>

    <hr>

    <!-- Cerrar sesión -->
    <div class="logout">
    <form method="POST" action="{{ route('logout.estudiante') }}">
        @csrf
        <button type="submit">
            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </button>
    </form>
</div>
</div>
