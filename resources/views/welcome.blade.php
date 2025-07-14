<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mesa de Partes Virtual</title>
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-seguimiento.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>

    <!-- ENCABEZADO -->
    <header class="header-welcome">
        <div class="header-left">
            <img src="{{ asset('images/logoppd.png') }}" alt="Logo del Instituto">
            <h1>IESTP "Pedro P. Díaz"</h1>
        </div>

        <div class="header-right">
            <form method="GET" action="{{ route('seguimiento.buscar') }}" class="busqueda-codigo">
                <input type="text" name="codigo" placeholder="Código de seguimiento" required>
                <button type="submit">Buscar</button>
            </form>
        </div>
    </header>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="contenido-welcome">
        <h2>Bienvenido al Sistema de Trámites Virtuales</h2>
        <h3>Iniciar Sesión</h3>

        <div class="login-boxes">
            <div class="login-card">
                <div class="login-icon"><i class="fas fa-user-graduate"></i></div>
                <h4>Estudiantes</h4>
                <a href="{{ route('login.estudiante') }}">Ingresar</a>
            </div>

            <div class="login-card">
                <div class="login-icon"><i class="fas fa-building-columns"></i></div>
                <h4>Personal Administrativo</h4>
                <a href="{{ route('login.mesapartes') }}">Ingresar</a>
            </div>
        </div>

        <br>

        <p class="soporte">Soporte técnico: PPD.mesa.virtual@pedrodiaz.edu.pe</p>
    </main>

    <!-- MODAL DE RESULTADO -->
    <div id="modalResultado" class="modal" style="display: none;">
        <div class="modal-contenido">
            <span class="cerrar-modal" onclick="cerrarModal()">&times;</span>

            @if(request()->has('codigo'))
                @if(isset($tramite))
                    <p><strong>Tipo:</strong> {{ ucwords(str_replace('_', ' ', $tramite->tipo_tramite)) }}</p>
                    <p><strong>Estado:</strong> {{ ucfirst($tramite->estado) }}</p>
                    <p><strong>Fecha:</strong> {{ $tramite->created_at->format('d/m/Y H:i') }}</p>
                    @if($tramite->estado === 'rechazado')
                        <p><strong>Motivo:</strong> {{ $tramite->respuesta }}</p>
                    @elseif($tramite->estado === 'derivado')
                        <p><strong>Derivado a:</strong> {{ $tramite->respuesta }}</p>
                    @endif
                @else
                    <p class="no-encontrado">Código no encontrado.</p>
                @endif
            @endif
        </div>
    </div>

    <script src="{{ asset('js/modal-seguimiento.js') }}"></script>

</body>
</html>
