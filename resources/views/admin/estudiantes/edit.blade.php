<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Estudiante</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/agregar-estudiante-formulario.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="admin-container">
        <h2><i class="fas fa-user-edit"></i> Editar Estudiante</h2>

        @if(session('success'))
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

        <form method="POST" action="{{ route('admin.estudiantes.update', $estudiante->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Código Estudiante</label>
                <input type="text" value="{{ $estudiante->codigo_estudiante }}" disabled>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $estudiante->nombre) }}" required>
                </div>

                <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" value="{{ old('correo', $estudiante->correo) }}" required>
                </div>
            </div>

            <div class="form-row">
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
                            <option value="{{ $esp }}" {{ old('especialidad', $estudiante->especialidad) == $esp ? 'selected' : '' }}>{{ $esp }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni" value="{{ old('dni', $estudiante->dni) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $estudiante->telefono) }}" required>
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" value="{{ old('direccion', $estudiante->direccion) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento) }}" required>
                </div>

                <div class="form-group">
                    <label for="genero">Género</label>
                    <select name="genero" id="genero" required>
                        <option value="">-- Seleccione --</option>
                        @foreach (['masculino', 'femenino'] as $gen)
                            <option value="{{ $gen }}" {{ old('genero', $estudiante->genero) == $gen ? 'selected' : '' }}>{{ ucfirst($gen) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Nueva Contraseña (opcional)</label>
                    <input type="password" name="password" id="password">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation">
                </div>
            </div>

            <div class="form-botones">
                <button type="submit" class="btn-guardar"><i class="fas fa-save"></i> Actualizar</button>
                <a href="{{ route('admin.estudiantes.index') }}" class="btn-cancelar"><i class="fas fa-arrow-left"></i> Cancelar</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/notificacion-crear-estudiante.js') }}"></script>

</body>
</html>
