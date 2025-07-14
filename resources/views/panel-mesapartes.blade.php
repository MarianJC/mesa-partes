<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel - Mesa de Partes</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-mesapartes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bandeja-tramites.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <!-- Sidebar -->
    @include('layouts.sidebar-mesapartes')

    <!-- Contenido -->
    <div class="main-content">
        <h2 class="titulo-seccion">Bandeja de Trámites - Mesa de Partes</h2>

        <div class="tabla-container">
            <table class="tabla-tramites">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Estudiante</th>
                        <th>Código</th>
                        <th>Tipo de Trámite</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Revisar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tramites as $i => $tramite)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $tramite->estudiante->nombre }}</td>
                        <td>{{ $tramite->estudiante->codigo_estudiante }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $tramite->tipo_tramite)) }}</td>
                        <td>{{ $tramite->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <span class="estado {{ $tramite->estado }}">
                                {{ ucfirst($tramite->estado) }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('mesapartes.revisar', $tramite->id) }}">Revisar</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7">No hay trámites pendientes</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
