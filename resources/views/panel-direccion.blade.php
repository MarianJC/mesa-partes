<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Trámites Asignados - Dirección Académica</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-mesapartes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/panel-direccion.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

@include('layouts.sidebar-mesapartes')

<div class="main-content">
    <h2 class="titulo">Trámites Asignados - Dirección Académica</h2>

        @if (session('success'))
            <div class="alert-exito">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

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
                        <td><span class="estado {{ $tramite->estado }}">{{ ucfirst($tramite->estado) }}</span></td>
                        <td>{{ $tramite->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('direccion.revisar', $tramite->id) }}" class="btn-ver">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No hay trámites asignados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

   <script src="{{ asset('js/notificacion-crear-estudiante.js') }}"></script>

</body>
</html>
