<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Revisar Trámite</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-mesapartes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/revisar-tramite.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
    @include('layouts.sidebar-mesapartes')

    <div class="main-content">
        <div class="revisar-box">
            <h2>Revisión del Trámite</h2>

            <div class="datos-tramite">
                <p><strong>Estudiante:</strong> {{ $tramite->estudiante->nombre }}</p>
                <p><strong>Código:</strong> {{ $tramite->estudiante->codigo_estudiante }}</p>
                <p><strong>Especialidad:</strong> {{ $tramite->especialidad }}</p>
                <p><strong>DNI:</strong> {{ $tramite->dni }}</p>
                <p><strong>Correo:</strong> {{ $tramite->correo }}</p>
                <p><strong>Tipo de trámite:</strong> {{ ucwords(str_replace('_', ' ', $tramite->tipo_tramite)) }}</p>
                <p><strong>Fecha de envío:</strong> {{ $tramite->created_at->format('d/m/Y H:i') }}</p>
                @if($tramite->descripcion)
                    <p><strong>Descripción:</strong> {{ $tramite->descripcion }}</p>
                @endif
            </div>

            <div class="visor-pdf">
                <p><strong>Documento enviado:</strong></p>
                <iframe src="{{ asset('storage/' . $tramite->archivo) }}" width="100%" height="400px"></iframe>
            </div>

            <div class="botones-acciones">
                <a href="{{ url('/panel-mesapartes') }}" class="btn-volver">Volver</a>

                <div class="acciones-derecha">
                    <form method="POST" action="{{ route('tramite.derivar', $tramite->id) }}" style="display:inline-block;">
                        @csrf
                        <button type="button" class="btn-derivar" onclick="abrirModalDerivar()">Derivar</button>
                    </form>

                    <button type="button" class="btn-rechazar" onclick="abrirModalRechazo()">Rechazar</button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal para rechazo -->
    <div id="modalRechazo" class="modal-rechazo">
        <div class="modal-contenido">
            <h3>Motivo del Rechazo</h3>
            <form method="POST" action="{{ route('tramite.rechazar', $tramite->id) }}">
                @csrf
                <textarea name="respuesta" placeholder="Escribe el motivo..." required></textarea>
                <div class="modal-botones">
                    <button type="submit" class="btn-confirmar">Confirmar</button>
                    <button type="button" onclick="cerrarModalRechazo()" class="btn-cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Derivación -->
    <div id="modalDerivar" class="modal-derivar"> 
        <div class="modal-derivar-contenido">    
            <h3>Derivar trámite a:</h3>
            <form method="POST" action="{{ route('tramite.derivar', $tramite->id) }}">
                @csrf
                <select name="destino" required>
                    <option value="">-- Selecciona un área --</option>
                    <option value="secretaria_academica">Secretaría Académica</option>
                    <option value="direccion_academica">Dirección Académica</option>
                </select>
                <div class="modal-botones">
                    <button type="submit" class="btn-confirmar">Confirmar</button>
                    <button type="button" onclick="cerrarModalDerivar()" class="btn-cancelar">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/modal-rechazar.js') }}"></script>
    <script src="{{ asset('js/modal-derivar.js') }}"></script>

</body>
</html>
