<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Estudiante</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-estudiante.css') }}">
    <link rel="stylesheet" href="{{ asset('css/panel-estudiante.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>
<body style="display: flex; margin: 0;">

    <!-- Sidebar -->
    @include('layouts.sidebar-estudiante')

    <!-- Contenido -->
    <div class="main-content">
        <div class="contenido-inicio">
            <h2>TRAMITES DISPONIBLES</h2>

                @if (session('success'))
                        <div class="alert-exito">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                @endif

            <div class="tramites-grid">
                <!-- Trámite 1 -->
                <div class="card-tramite">
                    <div class="icono-tramite"><i class="fas fa-calendar-minus"></i></div>
                    <h3>Reserva de Matrícula</h3>
                    <p>Solicita este trámite si necesitas reservar tu matrícula por motivos personales, 
                        laborales o de salud, y mantener tu vacante como estudiante activo</p>

                    <button class="btn-toggle" onclick="toggleRequisitos('requisitos-1')">
                        Ver requisitos
                    </button>

                    <div id="requisitos-1" class="requisitos" style="display: none;">
                        <ul>
                            <li>Solicitud simple indicando el motivo de la reserva</li>
                            <li>Constancia de Registro de Matricula del semestre vigente</li>
                            <li>Certificado original que sustente el motivo (laboral, salud, u otro)</li>
                            <li>Voucher o recibo de pago por matrícula</li>
                            <li>Copia de DNI</li>
                        </ul>
                        <p>“Todos los documentos deben ser reunidos y adjuntados en un único archivo PDF”</p>
                        <a href="{{ route('tramite.formulario', ['tipo' => 'reserva_matricula']) }}">
                            <button class="btn-iniciar">Iniciar Solicitud</button>
                        </a>
                    </div>
                </div>

                <!-- Trámite 2 -->
                <div class="card-tramite">
                    <div class="icono-tramite"><i class="fas fa-exchange-alt"></i></div>
                    <h3>Cambio de Turno</h3>
                    <p>Usa este trámite si necesitas cambiar del turno mañana a tarde o viceversa, por motivos de trabajo, 
                        salud u otros debidamente justificados</p>

                    <button class="btn-toggle" onclick="toggleRequisitos('requisitos-2')">
                        Ver requisitos
                    </button>

                    <div id="requisitos-2" class="requisitos" style="display: none;">
                        <ul>
                            <li>Solicitud indicando el motivo de su cambio de turno incluyendo: Datos personales del estudiante, Datos académicos (carrera, turno actual, semestre y/o años de estudio) y firma del solicitante</li>
                            <li>Documento sustentatorio según el motivo de solicitud: Certificado de trabajo, Certificado de salud, Recibos de sumisnistro de luz y agua, segun sea el motivo por el cual solicita el cambio de turno</li>
                            <li>Reporte de Notas</li>
                            <li>Copia DNI</li>
                        </ul>
                        <p>“Todos los documentos deben ser reunidos y adjuntados en un único archivo PDF”</p>
                        <a href="{{ route('tramite.formulario', ['tipo' => 'cambio_turno']) }}">
                            <button class="btn-iniciar">Iniciar Solicitud</button>
                        </a>
                    </div>
                </div>

                <!-- Trámite 3 -->
                <div class="card-tramite">
                    <div class="icono-tramite"><i class="fas fa-clipboard-list"></i></div>
                    <h3>Reporte de Notas</h3>
                    <p>Este trámite es para estudiantes que han estado inactivos uno o más semestres 
                        y desean retomar sus estudios en la institución</p>

                    <button class="btn-toggle" onclick="toggleRequisitos('requisitos-3')">
                        Ver requisitos
                    </button>

                    <div id="requisitos-3" class="requisitos" style="display: none;">
                        <ul>
                            <li>Solicitud con datos personales y de estudio (Carrera, turno y semestre o años de estudio)</li>
                            <li>Voucher o recibo de pago por derecho de trámite: Monto S/ 5.00 nuevos soles </li>
                            <li>Copia de DNI</li>
                        </ul>
                        <p>“Todos los documentos deben ser reunidos y adjuntados en un único archivo PDF”</p>
                        <a href="{{ route('tramite.formulario', ['tipo' => 'reporte_notas']) }}">
                            <button class="btn-iniciar">Iniciar Solicitud</button>
                        </a>
                    </div>
                </div>

                <!-- Trámite 4 -->
                <div class="card-tramite">
                    <div class="icono-tramite"><i class="fas fa-sign-in-alt"></i></div>
                    <h3>Reingresos</h3>
                    <p>Solicita un informe oficial con tus calificaciones de uno o más periodos académicos, 
                        útil para trámites externos o seguimiento académico</p>

                    <button class="btn-toggle" onclick="toggleRequisitos('requisitos-4')">
                        Ver requisitos
                    </button>

                    <div id="requisitos-4" class="requisitos" style="display: none;">
                        <ul>
                            <li>Solicitud con datos personales, de estudio (Carrera, turno, semestre o año de estudios firmado por el solicitante)</li>
                            <li>Reporte de notas del último ciclo académico cursado</li>
                            <li>Copia de DNI</li>
                        </ul>
                        <p>“Todos los documentos deben ser reunidos y adjuntados en un único archivo PDF”</p>
                        <a href="{{ route('tramite.formulario', ['tipo' => 'reingreso']) }}">
                            <button class="btn-iniciar">Iniciar Solicitud</button>
                        </a>
                    </div>
                </div>

                <!-- Trámite 5 -->
                <div class="card-tramite">
                    <div class="icono-tramite"><i class="fas fa-random"></i></div>
                    <h3>Cambio de Especialidad</h3>
                    <p>Si deseas cambiarte a otra carrera técnica dentro del instituto, 
                        puedes iniciar este trámite indicando tu nueva especialidad de interés</p>

                    <button class="btn-toggle" onclick="toggleRequisitos('requisitos-5')">
                        Ver requisitos
                    </button>

                    <div id="requisitos-5" class="requisitos" style="display: none;">
                        <ul>
                            <li>Solicitud, con datos personales, de estudio (Carrera actual, turno, semestre o año de estudios), nueva especialidad a la que desea cambiarse, motivo de solicitud y firmado por el solicitante)</li>
                            <li>Reporte de notas del semestre actual o del último semestre cursado</li>
                            <li>Copia de DNI</li>
                        </ul>
                        <p>“Todos los documentos deben ser reunidos y adjuntados en un único archivo PDF”</p>
                        <a href="{{ route('tramite.formulario', ['tipo' => 'cambio_especialidad']) }}">
                            <button class="btn-iniciar">Iniciar Solicitud</button>
                        </a>
                    </div>
                </div>

                <!-- Trámite 6 -->
                <div class="card-tramite">
                    <div class="icono-tramite"><i class="fas fa-chart-line"></i></div>
                    <h3>Ranking de Notas</h3>
                    <p>Solicita el ranking académico del ciclo actual o anterior. 
                        Este documento es útil para becas, prácticas o validación de tu rendimiento académico.</p>

                    <button class="btn-toggle" onclick="toggleRequisitos('requisitos-6')">
                        Ver requisitos
                    </button>

                    <div id="requisitos-6" class="requisitos" style="display: none;">
                        <ul>
                            <li>Solicitud indicando el ciclo académico</li>
                            <li>Voucher o Recibo de pago de matrícula</li>
                            <li>Copia de DNI</li>
                        </ul>
                        <p>“Todos los documentos deben ser reunidos y adjuntados en un único archivo PDF”</p>
                        <a href="{{ route('tramite.formulario', ['tipo' => 'ranking_notas']) }}">
                            <button class="btn-iniciar">Iniciar Solicitud</button>
                        </a>
                    </div>
                </div>
                            
            </div>
        </div>
    </div>
<script src="{{ asset('js/panel-estudiante.js') }}"></script>
<script src="{{ asset('js/notificacion-crear-estudiante.js') }}"></script>

</body>
</html>
