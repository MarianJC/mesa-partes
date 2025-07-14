<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Trámites</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-mesapartes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/historial-tramites.css') }}">
    <link rel="stylesheet" href="{{ asset('css/modal-historial.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('layouts.sidebar-mesapartes')

    <div class="main-content">
        <h2 class="titulo-tramites">Historial de Trámites</h2>

        <div class="filtros">
            <a href="{{ route('mesapartes.historial') }}" class="{{ !$estado ? 'activo' : '' }}">Todos</a>
            <a href="{{ route('mesapartes.historial', ['estado' => 'derivado']) }}" class="{{ $estado === 'derivado' ? 'activo' : '' }}">Derivados</a>
            <a href="{{ route('mesapartes.historial', ['estado' => 'rechazado']) }}" class="{{ $estado === 'rechazado' ? 'activo' : '' }}">Rechazados</a>
        </div>

        <div class="tabla-container">
            <table class="tabla-tramites">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Estudiante</th>
                        <th>Código</th>
                        <th>Trámite</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tramites as $i => $tramite)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $tramite->estudiante->nombre }}</td>
                            <td>{{ $tramite->estudiante->codigo_estudiante }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $tramite->tipo_tramite)) }}</td>
                            <td>
                                <span class="estado {{ $tramite->estado }}">
                                    {{ ucfirst($tramite->estado) }}
                                </span>
                            </td>
                            <td>
                                @if($tramite->estado === 'derivado' && $tramite->fecha_derivacion)
                                    {{ \Carbon\Carbon::parse($tramite->fecha_derivacion)->format('d/m/Y H:i') }}
                                @elseif($tramite->estado === 'rechazado' && $tramite->fecha_rechazo)
                                    {{ \Carbon\Carbon::parse($tramite->fecha_rechazo)->format('d/m/Y H:i') }}
                                @else
                                    {{ $tramite->created_at->format('d/m/Y H:i') }}
                                @endif
                            </td>

                            <td>
                                <button onclick="mostrarDetalle({{ $tramite->id }})" class="btn-ver">Ver</button>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No hay trámites registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="modalDetalle" class="modal-detalle">
        <div class="modal-contenido">
            <h3>Detalle del Trámite</h3>
            <div id="modal-info">
                <!-- Aquí se llena con JS -->
            </div>
            <button onclick="cerrarModalDetalle()" class="btn-cerrar">Cerrar</button>
        </div>
    </div>

    <script src="{{ asset('js/modal-historial.js') }}"></script>

</body>
</html>
