<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Mesa de Partes</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="login-container">
    <div class="login-form">

        <h2>¡Hola Personal Administrativo!</h2>
        <p>Inicia sesión en tu cuenta</p>

         <!-- BLOQUE DE ERRORES -->
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login.mesapartes.post') }}">
            @csrf

            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="usuario" placeholder="Usuario" required>
            </div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Contraseña" required>
            </div>

            <div class="extra-options">
                <label><input type="checkbox" name="remember"> Recordarme</label>
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>

    <div class="login-info">

        <a href="{{ route('inicio') }}" class="btn-cerrar-login-info">
            <i class="fas fa-times"></i>
        </a>
        
        <h2>¡Bienvenido de nuevo!</h2>
        <p>Ingresa tus credenciales para continuar al panel del Area Administrativa correspondiente.</p>
    </div>
</div>

</body>
</html>
