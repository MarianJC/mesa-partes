<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-estudiante.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notificaciones.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body>
    @include('layouts.sidebar-estudiante')

    <div class="main-content">
        <h2>Mis Notificaciones</h2>

        @forelse ($notificaciones as $noti)
            <div class="notificacion-card {{ $noti->tipo }}">
                <div class="fecha">
                    @switch($noti->tipo)
                        @case('rechazado')
                            <i class="fas fa-times-circle icono tipo-rechazado"></i>
                            @break
                        @case('atendido')
                            <i class="fas fa-check-circle icono tipo-atendido"></i>
                            @break
                        @case('derivado')
                            <i class="fas fa-share-square icono tipo-derivado"></i>
                            @break
                        @default
                            <i class="fas fa-bell icono tipo-default"></i>
                    @endswitch
                    [{{ $noti->created_at->format('d/m/Y H:i') }}]
                </div>

                <div class="mensaje">
                    {!! $noti->mensaje !!}
                </div>

                <div class="acciones">
                    <form action="{{ route('notificacion.eliminar', $noti->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-eliminar">Eliminar</button>
                    </form>

                    @unless($noti->leido)
                        <form method="POST" action="{{ route('notificacion.leer', $noti->id) }}" style="display:inline;">
                            @csrf
                            <button class="btn-leer">Marcar como leída</button>
                        </form>
                    @endunless
                </div>
            </div>
        @empty
            <p>No tienes notificaciones por el momento</p>
        @endforelse

    </div>
</body>
</html>
