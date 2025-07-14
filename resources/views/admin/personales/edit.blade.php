<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Personal</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/agregar-personal-formulario.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="admin-container">
        <h2><i class="fas fa-user-edit"></i> Editar Personal</h2>

        @if(session('success'))
            <div class="alert-exito">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.personales.update', $personal->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" value="{{ old('usuario', $personal->usuario) }}" required>
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre Completo</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $personal->nombre) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" name="correo" value="{{ old('correo', $personal->correo) }}">
                </div>

                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select name="rol" required>
                        <option value="">-- Selecciona un rol --</option>
                        <option value="mesa_de_partes" {{ $personal->rol == 'mesa_de_partes' ? 'selected' : '' }}>Mesa de Partes</option>
                        <option value="secretaria_academica" {{ $personal->rol == 'secretaria_academica' ? 'selected' : '' }}>Secretaría Académica</option>
                        <option value="direccion_academica" {{ $personal->rol == 'direccion_academica' ? 'selected' : '' }}>Dirección Académica</option>
                        <option value="admin" {{ $personal->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" value="{{ old('dni', $personal->dni) }}">
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono', $personal->telefono) }}">
                </div>
            </div>

            <div class="form-group full-width">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" value="{{ old('direccion', $personal->direccion) }}">
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
                <button type="submit" class="btn-guardar"><i class="fas fa-save"></i> Guardar Cambios</button>
                <a href="{{ route('admin.personales.index') }}" class="btn-cancelar">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/notificacion-crear-estudiante.js') }}"></script>
    
</body>
</html>
