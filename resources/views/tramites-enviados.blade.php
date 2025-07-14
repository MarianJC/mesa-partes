<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Trámites Enviados</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-estudiante.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tramites-enviados.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-detalles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-rechazarestudiante.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('layouts.sidebar-estudiante')

    <div class="main-content">
        <h2 class="titulo-tramites">TRÁMITES ENVIADOS</h2>

        <!-- Buscador por código -->
        <form method="GET" action="{{ route('tramites.enviados') }}" style="margin-bottom: 20px;">
            <label for="codigo">Buscar por código de seguimiento:</label>
            <input type="text" name="codigo" id="codigo" placeholder="Ej. PPD-66B15E42" style="padding: 6px 10px; margin-left: 10px;">
            <button type="submit" style="padding: 6px 14px;">Buscar</button>
        </form>

        <div class="tabla-container">
            <table class="tabla-tramites">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Tipo de Trámite</th>
                        <th>Fecha de Envío</th>
                        <th>Estado</th>
                        <th>Ver</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tramites as $i => $tramite)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $tramite->codigo_seguimiento ?? '—' }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $tramite->tipo_tramite)) }}</td>
                            <td>{{ $tramite->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="estado {{ $tramite->estado }}">{{ ucfirst($tramite->estado) }}</span>
                            </td>
                            <td>
                                <button onclick="mostrarDetalles({{ $tramite->id }})" class="btn-detalles">
                                    <i class="fas fa-file-alt"></i>
                                </button>
                            </td>
                            <td>
                                @if($tramite->estado === 'rechazado' && $tramite->respuesta)
                                    <a href="#" onclick="mostrarObservacion(`{{ $tramite->respuesta }}`)" title="Ver Observación">
                                        <i class="fas fa-exclamation-circle" style="color: #dc2626; font-size: 18px;"></i>
                                    </a>
                                @elseif($tramite->estado === 'atendido' && $tramite->respuesta)
                                    <a href="{{ asset('storage/' . $tramite->respuesta) }}" target="_blank" title="Descargar Respuesta">
                                        <i class="fas fa-file-download" style="color: #1e40af; font-size: 18px;"></i>
                                    </a>
                                @else
                                    <span style="color: gray;">—</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No has enviado ningún trámite aún.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Detalles -->
    <div id="modalDetalle" class="modal-detalle-estudiante" style="display: none;">
        <div class="modal-contenido">
            <h3>Detalles del Trámite</h3>
            <div id="detalleContenido">
                <!-- Aquí se insertarán los datos -->
            </div>
            <button onclick="cerrarModalDetalle()" class="btn-cerrar">Cerrar</button>
        </div>
    </div>

    <!-- Modal para mostrar observación -->
    <div id="modalObservacion" class="modal-rechazo-estudiante">
        <div class="modal-contenido">
            <h3>Observación del Trámite</h3>
            <p id="textoObservacion"></p>
            <button class="btn-cerrar" onclick="cerrarObservacion()">Cerrar</button>
        </div>
    </div>

    <script src="{{ asset('js/modal-detalles.js') }}"></script>
    <script src="{{ asset('js/modal-observacion.js') }}"></script>
</body>
</html>
