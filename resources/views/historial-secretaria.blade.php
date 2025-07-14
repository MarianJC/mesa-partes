<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Trámites - Secretaría Académica</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-mesapartes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/historial-secretaria.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

@include('layouts.sidebar-mesapartes')

<div class="main-content">
    <h2 class="titulo-tramites">Historial de Trámites - Secretaría Académica</h2>

    <div class="filtros">
        <a href="{{ route('secretaria.historial') }}" class="{{ !$estado ? 'activo' : '' }}">Todos</a>
        <a href="{{ route('secretaria.historial', ['estado' => 'derivado']) }}" class="{{ $estado === 'derivado' ? 'activo' : '' }}">Derivados</a>
        <a href="{{ route('secretaria.historial', ['estado' => 'atendido']) }}" class="{{ $estado === 'atendido' ? 'activo' : '' }}">Atendidos</a>
    </div>

    <div class="tabla-container">
        <table class="tabla-tramites">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Estudiante</th>
                    <th>Código</th>
                    <th>Tipo de Trámite</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tramites as $index => $tramite)
                    <tr>
                        <td>{{ $index + 1 }}</td>
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
                            @elseif($tramite->estado === 'atendido')
                                {{ $tramite->updated_at->format('d/m/Y H:i') }}
                            @else
                                {{ $tramite->created_at->format('d/m/Y H:i') }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('secretaria.revisar', $tramite->id) }}" class="btn-ver">Ver</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No hay trámites registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
