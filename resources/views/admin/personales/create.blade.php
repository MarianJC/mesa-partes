<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Personal</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/agregar-personal-formulario.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="admin-container">
        <h2><i class="fas fa-user-plus"></i> Registrar Nuevo Personal</h2>

        @if (session('success'))
            <div class="alert-exito">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-errores">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.personales.store') }}" method="POST">
            @csrf

            {{-- Fila 1: Usuario y Nombre --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" id="usuario" required>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" required>
                </div>
            </div>

            {{-- Fila 2: Correo y Rol --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" name="correo" id="correo">
                </div>
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select name="rol" id="rol" required>
                        <option value="">-- Seleccione --</option>
                        <option value="mesa_de_partes">Mesa de Partes</option>
                        <option value="secretaria_academica">Secretaría Académica</option>
                        <option value="direccion_academica">Dirección Académica</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
            </div>

            {{-- Fila 3: DNI y Teléfono --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" id="dni">
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="telefono">
                </div>
            </div>

            {{-- Fila 4: Dirección (una sola columna) --}}
            <div class="form-group full-width">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion">
            </div>

            {{-- Fila 5: Contraseña y Confirmación --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                </div>
            </div>

            {{-- Botones --}}
            <div class="form-botones">
                <button type="submit" class="btn-guardar">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('admin.personales.index') }}" class="btn-cancelar"><i class="fas fa-arrow-left"></i> Cancelar</a>
            </div>
        </form>

    </div>

       <script src="{{ asset('js/notificacion-crear-estudiante.js') }}"></script>

    </body>
</html>
