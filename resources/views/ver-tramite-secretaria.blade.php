<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Revisar Trámite - Secretaría Académica</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-mesapartes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ver-tramite-secretaria.css') }}">
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

            <form method="POST" action="{{ route('secretaria.atender', $tramite->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label><strong>Subir respuesta (PDF):</strong></label>
                    <input type="file" name="respuesta" accept="application/pdf" required>
                </div>

                <div class="botones-acciones">
                    <a href="{{ route('panel.secretaria') }}" class="btn-volver">Volver</a>
                    <button type="submit" class="btn-responder">Responder</button>
                </div>
            </form>

            <form method="POST" action="{{ route('secretaria.derivar', $tramite->id) }}">
                @csrf
                <input type="hidden" name="destino" value="direccion_academica">
                
                <div class="botones-acciones">
                    <button type="submit" class="btn-derivar">
                        Derivar a Dirección Académica
                    </button>
                </div>
            </form>

        </div>
    </div>

</body>
</html>
