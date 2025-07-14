<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Trámite</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-estudiante.css') }}">
    <link rel="stylesheet" href="{{ asset('css/formulario-tramite.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('layouts.sidebar-estudiante')

    <div class="main-content">
        <div class="formulario-box">
    <h2>Iniciar Solicitud - {{ ucwords(str_replace('_', ' ', $tipo)) }}</h2>

    <form method="POST" action="{{ route('tramite.enviar') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="tipo_tramite" value="{{ $tipo }}">

        <div class="form-grid">
            <div>
                <label>Nombre Completo:</label>
                <input type="text" name="nombre" value="{{ Auth::guard('estudiante')->user()->nombre }}" readonly>
            </div>

            <div>
                <label>Código de Estudiante:</label>
                <input type="text" name="codigo" value="{{ Auth::guard('estudiante')->user()->codigo_estudiante }}" readonly>
            </div>

            <div>
                <label>Especialidad:</label>
                <select name="especialidad" required>
                    <option value="">-- Seleccione --</option>
                    <option value="Asistencia Administrativa" {{ Auth::guard('estudiante')->user()->especialidad == 'Asistencia Administrativa' ? 'selected' : '' }}>Asistencia Administrativa</option>
                    <option value="Construcción Civil" {{ Auth::guard('estudiante')->user()->especialidad == 'Construcción Civil' ? 'selected' : '' }}>Construcción Civil</option>
                    <option value="Contabilidad" {{ Auth::guard('estudiante')->user()->especialidad == 'Contabilidad' ? 'selected' : '' }}>Contabilidad</option>
                    <option value="Desarrollo de Sistemas de Información" {{ Auth::guard('estudiante')->user()->especialidad == 'Desarrollo de Sistemas de Información' ? 'selected' : '' }}>Desarrollo de Sistemas de Información</option>
                    <option value="Electricidad Industrial" {{ Auth::guard('estudiante')->user()->especialidad == 'Electricidad Industrial' ? 'selected' : '' }}>Electricidad Industrial</option>
                    <option value="Electrónica Industrial" {{ Auth::guard('estudiante')->user()->especialidad == 'Electrónica Industrial' ? 'selected' : '' }}>Electrónica Industrial</option>
                    <option value="Mecatrónica Automotriz" {{ Auth::guard('estudiante')->user()->especialidad == 'Mecatrónica Automotriz' ? 'selected' : '' }}>Mecatrónica Automotriz</option>
                    <option value="Mecánica de Producción Industrial" {{ Auth::guard('estudiante')->user()->especialidad == 'Mecánica de Producción Industrial' ? 'selected' : '' }}>Mecánica de Producción Industrial</option>
                    <option value="Producción Agropecuaria" {{ Auth::guard('estudiante')->user()->especialidad == 'Producción Agropecuaria' ? 'selected' : '' }}>Producción Agropecuaria</option>

                </select>
            </div>

            <div>
                <label>DNI:</label>
                <input type="text" name="dni" value="{{ Auth::guard('estudiante')->user()->dni }}" required>
            </div>

            <div style="grid-column: 1 / -1;">
                <label>Correo electrónico:</label>
                <input type="email" name="correo" value="{{ Auth::guard('estudiante')->user()->email }}" required>
            </div>

            <div style="grid-column: 1 / -1;">
                <label>Descripción (opcional):</label>
                <textarea name="descripcion" rows="4" placeholder="Puedes añadir una observación adicional si lo deseas..."></textarea>
            </div>

            <div style="grid-column: 1 / -1;">
                <label>Archivo PDF con requisitos:</label>
                <input type="file" name="archivo" accept="application/pdf" required>
                <p style="font-size: 13px; color: gray;">Debe adjuntar todos los documentos requeridos en un solo archivo PDF</p>
            </div>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-enviar">Enviar Solicitud</button>
            <a href="{{ url('/panel-estudiante') }}" class="btn-cancelar">Cancelar</a>
        </div>
    </form>
</div>

    </div>
</body>
</html>
