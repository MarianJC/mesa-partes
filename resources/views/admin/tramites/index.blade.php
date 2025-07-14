<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Global de Trámites</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-tramites.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="admin-container">
        <h2>Panel Global de Trámites</h2>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert-exito">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Filtros -->
        <form method="GET" class="form-filtros">
            <div class="form-row">
                <div class="form-group">
                    <label>Estado:</label>
                    <select name="estado">
                        <option value="">-- Todos --</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="derivado">Derivado</option>
                        <option value="rechazado">Rechazado</option>
                        <option value="atendido">Atendido</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Área destino:</label>
                    <select name="area_destino">
                        <option value="">-- Todas --</option>
                        <option value="mesa_de_partes">Mesa de Partes</option>
                        <option value="secretaria_academica">Secretaría Académica</option>
                        <option value="direccion_academica">Dirección Académica</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tipo de trámite:</label>
                    <input type="text" name="tipo_tramite" placeholder="Ej: Cambio de Turno">
                </div>

                <div class="form-group">
                    <label>Nombre del estudiante:</label>
                    <input type="text" name="estudiante" placeholder="Ej: Ana Torres">
                </div>

                <div class="form-group">
                    <label>Fecha:</label>
                    <input type="date" name="fecha">
                </div>
            </div>

            <div class="form-botones">
                <button type="submit" class="btn-filtrar"><i class="fas fa-filter"></i> Filtrar</button>
                <a href="{{ route('admin.tramites.index') }}" class="btn-cancelar"><i class="fas fa-times"></i> Limpiar</a>
            </div>
        </form>

        <!-- Tabla de Trámites -->
        <table class="tabla-tramites">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Estudiante</th>
                    <th>Tipo</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Área destino</th>
                    <th>Ver archivo</th>
                    <th>Respuesta</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tramites as $i => $tramite)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $tramite->estudiante->nombre }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $tramite->tipo_tramite)) }}</td>
                        <td>{{ ucfirst($tramite->estado) }}</td>
                        <td>{{ $tramite->created_at->format('d/m/Y') }}</td>
                        <td>{{ $nombresAreas[$tramite->area_destino] ?? '-' }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $tramite->archivo) }}" target="_blank">
                                <i class="fas fa-file-pdf" style="color: red;"></i>
                            </a>
                        </td>
                        <td>
                            @if ($tramite->respuesta)
                                <button class="btn-ver-respuesta" onclick="mostrarRespuesta('{{ addslashes($tramite->respuesta) }}')">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8">No hay trámites registrados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal de respuesta -->
    <div id="modal-respuesta" class="modal">
        <div class="modal-contenido">
            <p id="respuesta-texto"></p>
            <div class="modal-botones">
                <button onclick="cerrarModal()" class="btn-cancelar">Cerrar</button>
            </div>
        </div>
    </div>

    <script>
        function mostrarRespuesta(texto) {
            document.getElementById('respuesta-texto').innerText = texto;
            document.getElementById('modal-respuesta').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('modal-respuesta').style.display = 'none';
        }
    </script>
</body>
</html>
