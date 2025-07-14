<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Trámites - Dirección Académica</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-mesapartes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/historial-tramites.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

@include('layouts.sidebar-mesapartes')

<div class="main-content">
    <h2 class="titulo-tramites">Historial de Trámites - Dirección Académica</h2>

    <div class="filtros">
        <a href="{{ route('direccion.historial') }}" class="{{ !$estado ? 'activo' : '' }}">Todos</a>
        <a href="{{ route('direccion.historial', ['estado' => 'atendido']) }}" class="{{ $estado === 'atendido' ? 'activo' : '' }}">Atendidos</a>
        <a href="{{ route('direccion.historial', ['estado' => 'reasignado']) }}" class="{{ $estado === 'reasignado' ? 'activo' : '' }}">Reasignados</a>
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
                        <td><span class="estado {{ $tramite->estado }}">{{ ucfirst($tramite->estado) }}</span></td>
                        <td>{{ $tramite->updated_at->format('d/m/Y H:i') }}</td>
                        <td><a href="{{ route('direccion.revisar', $tramite->id) }}" class="btn-ver">Ver</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No hay trámites en el historial.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
