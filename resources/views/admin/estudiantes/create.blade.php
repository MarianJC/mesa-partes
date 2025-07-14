<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nuevo Estudiante</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/agregar-estudiante-formulario.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="admin-container">
        <h2><i class="fas fa-user-plus"></i> Registrar Nuevo Estudiante</h2>

        @if (session('success'))
            <div class="alert-exito">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-errores">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.estudiantes.store') }}">
            @csrf

            <!-- Nombre completo -->
            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
            </div>

            <!-- DNI + Teléfono -->
            <div class="form-row">
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni" maxlength="15" value="{{ old('dni') }}" required>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" maxlength="20" value="{{ old('telefono') }}" required>
                </div>
            </div>

            <!-- Dirección -->
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion" maxlength="255" value="{{ old('direccion') }}" required>
            </div>

            <!-- Fecha de Nacimiento + Género -->
            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
                </div>

                <div class="form-group">
                    <label for="genero">Género</label>
                    <select name="genero" id="genero" required>
                        <option value="">-- Seleccione --</option>
                        <option value="masculino" {{ old('genero') == 'masculino' ? 'selected' : '' }}>Masculino</option>
                        <option value="femenino" {{ old('genero') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                    </select>
                </div>
            </div>

            <!-- Correo + Especialidad -->
            <div class="form-row">
                <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" value="{{ old('correo') }}" required>
                </div>

                <div class="form-group">
                    <label for="especialidad">Especialidad</label>
                    <select name="especialidad" id="especialidad" required>
                        <option value="">-- Seleccione --</option>
                        @foreach ([
                            'Construcción Civil',
                            'Desarrollo de Sistemas de Información',
                            'Contabilidad',
                            'Producción Agropecuaria',
                            'Asistencia Administrativa',
                            'Electricidad Industrial',
                            'Electrónica Industrial',
                            'Mecatrónica Automotriz',
                            'Mecánica de Producción Industrial'
                        ] as $esp)
                            <option value="{{ $esp }}" {{ old('especialidad') == $esp ? 'selected' : '' }}>{{ $esp }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Contraseña + Confirmar -->
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Contraseña Inicial</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                </div>
            </div>

            <!-- Botones -->
            <div class="form-botones">
                <button type="submit" class="btn-guardar"><i class="fas fa-save"></i> Guardar</button>
                <a href="{{ route('admin.estudiantes.index') }}" class="btn-cancelar"><i class="fas fa-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/notificacion-crear-estudiante.js') }}"></script>

</body>
</html>
