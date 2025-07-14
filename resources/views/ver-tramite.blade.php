<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle del Trámite</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-estudiante.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formulario-tramite.css') }}">
</head>
<body>
    @include('layouts.sidebar-estudiante')

    <div class="main-content">
        <div class="formulario-box">
            <h2>Detalles del Trámite Realizado</h2>

            <ul style="line-height: 2;">
                <li><strong>Tipo de Trámite:</strong> {{ ucwords(str_replace('_', ' ', $tramite->tipo_tramite)) }}</li>
                <li><strong>Fecha de Envío:</strong> {{ $tramite->created_at->timezone('America/Lima')->format('d/m/Y H:i') }}</li>
                <li><strong>Especialidad:</strong> {{ $tramite->especialidad }}</li>
                <li><strong>DNI:</strong> {{ $tramite->dni }}</li>
                <li><strong>Correo:</strong> {{ $tramite->correo }}</li>
                <li><strong>Descripción:</strong> {{ $tramite->descripcion ?? 'No registrada' }}</li>
                <li><strong>Estado:</strong> {{ ucfirst($tramite->estado) }}</li>
                <li><strong>Archivo Enviado:</strong>
                    <a href="{{ asset('storage/' . $tramite->archivo) }}" target="_blank">📎 Ver PDF</a>
                </li>
            </ul>

            <a href="{{ url('/tramites-enviados') }}" class="btn-cancelar">← Volver a la Lista</a>
        </div>
    </div>
</body>
</html>
