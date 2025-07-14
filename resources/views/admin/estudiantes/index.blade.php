<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Estudiantes</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-estudiantes.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="admin-container">
        <h2>Gestión de Estudiantes</h2>

        <a href="{{ route('admin.estudiantes.create') }}" class="btn-agregar">
            <i class="fas fa-user-plus"></i> Nuevo Estudiante
        </a>

        <div class="tabla-scroll">
            <table class="tabla-estudiantes">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Especialidad</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Fecha Nac.</th>
                        <th>Género</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($estudiantes as $i => $est)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $est->codigo_estudiante }}</td>
                            <td>{{ $est->dni }}</td>
                            <td>{{ $est->nombre }}</td>
                            <td>{{ $est->correo }}</td>
                            <td>{{ $est->especialidad }}</td>
                            <td>{{ $est->telefono }}</td>
                            <td>{{ $est->direccion }}</td>
                            <td>{{ \Carbon\Carbon::parse($est->fecha_nacimiento)->format('d/m/Y') }}</td>
                            <td>{{ ucfirst($est->genero) }}</td>
                            <td>
                                <a href="{{ route('admin.estudiantes.edit', $est->id) }}" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.estudiantes.destroy', $est->id) }}"
                                            method="POST"
                                            class="form-eliminar"
                                            data-nombre="{{ $est->nombre }}">

                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: none; border: none; cursor: pointer;" title="Eliminar">
                                        <i class="fas fa-trash-alt" style="color: red;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="11">No hay estudiantes registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="modal-confirmar" class="modal">
        <div class="modal-contenido">
            <p id="modal-texto"></p>
            <div class="modal-botones">
                <button id="btn-cancelar">Cancelar</button>
                <button id="btn-confirmar">Eliminar</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/modal-eliminar-registro.js') }}"></script>

</body>
</html>
