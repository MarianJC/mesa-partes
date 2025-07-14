<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Personal</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-personal.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="admin-container">
        <h2>Gestión de Personal</h2>

        @if(session('success'))
            <div class="alert-exito">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.personales.create') }}" class="btn-agregar">
            <i class="fas fa-user-plus"></i> Nuevo Personal
        </a>

        <table class="tabla-personal">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($personales as $i => $personal)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $personal->usuario }}</td>
                        <td>{{ $personal->nombre }}</td>
                        <td>{{ $personal->correo ?? '-' }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $personal->rol)) }}</td>
                        <td>{{ $personal->dni ?? '-' }}</td>
                        <td>{{ $personal->telefono ?? '-' }}</td>
                        <td>{{ $personal->direccion ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.personales.edit', $personal->id) }}" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.personales.destroy', $personal->id) }}"
                                  method="POST"
                                  class="form-eliminar"
                                  data-nombre="{{ $personal->nombre }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Eliminar" style="background: none; border: none; cursor: pointer;">
                                    <i class="fas fa-trash-alt" style="color: red;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9">No hay personal registrado</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal personalizado para confirmar eliminación -->
    <div id="modal-confirmar" class="modal">
        <div class="modal-contenido">
            <p id="modal-texto"></p>
            <div class="modal-botones">
                <button id="btn-cancelar">Cancelar</button>
                <button id="btn-confirmar">Eliminar</button>
            </div>
        </div>
    </div>

    <script>
        let formularioActual = null;

        document.querySelectorAll('.form-eliminar').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                formularioActual = this;
                const nombre = this.dataset.nombre;

                document.getElementById('modal-texto').textContent =
                    `¿Seguro que deseas eliminar a "${nombre}"?`;
                document.getElementById('modal-confirmar').style.display = 'flex';
            });
        });

        document.getElementById('btn-cancelar').addEventListener('click', () => {
            document.getElementById('modal-confirmar').style.display = 'none';
        });

        document.getElementById('btn-confirmar').addEventListener('click', () => {
            if (formularioActual) formularioActual.submit();
        });

        setTimeout(() => {
            const alerta = document.querySelector('.alert-exito');
            if (alerta) {
                alerta.style.transition = 'opacity 0.6s';
                alerta.style.opacity = '0';
                setTimeout(() => alerta.remove(), 600);
            }
        }, 3000);
    </script>
</body>
</html>
