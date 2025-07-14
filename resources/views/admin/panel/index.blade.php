<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel General del Administrador</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/panel-admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    @include('layouts.sidebar-admin')

    <div class="admin-container">
        <h2>Panel General del Administrador</h2>

        <div class="dashboard-cards">
            <div class="card resumen">
                <h3>Total Trámites</h3>
                <p>{{ $totalTramites }}</p>
            </div>
            <div class="card pendiente">
                <h3>Pendientes</h3>
                <p>{{ $pendientes }}</p>
            </div>
            <div class="card atendido">
                <h3>Atendidos</h3>
                <p>{{ $atendidos }}</p>
            </div>
            <div class="card rechazado">
                <h3>Rechazados</h3>
                <p>{{ $rechazados }}</p>
            </div>
            <div class="card derivado">
                <h3>Derivados</h3>
                <p>{{ $derivados }}</p>
            </div>
            <div class="card estudiantes">
                <h3>Estudiantes</h3>
                <p>{{ $totalEstudiantes }}</p>
            </div>
            <div class="card personal">
                <h3>Personal</h3>
                <p>{{ $totalPersonal }}</p>
            </div>
        </div>

        <div class="grafico-tramites">
            <h3>Trámites registrados en los últimos 7 días</h3>
            <canvas id="graficoTramites"></canvas>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('graficoTramites').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($fechas) !!},
                datasets: [{
                    label: 'Trámites por Día',
                    data: {!! json_encode($cantidadesPorDia) !!},
                    backgroundColor: '#007BFF'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false, 
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
