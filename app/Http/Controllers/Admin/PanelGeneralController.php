<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tramite;
use App\Models\Estudiante;
use App\Models\Personal;
use Carbon\Carbon;

class PanelGeneralController extends Controller
{
    public function index()
    {
        $totalTramites = Tramite::count();
        $pendientes = Tramite::where('estado', 'pendiente')->count();
        $derivados = Tramite::where('estado', 'derivado')->count();
        $rechazados = Tramite::where('estado', 'rechazado')->count();
        $atendidos = Tramite::where('estado', 'atendido')->count();

        $totalEstudiantes = Estudiante::count();
        $totalPersonal = Personal::count();

        // Trámites de los últimos 7 días
        $tramitesUltimos7Dias = Tramite::selectRaw("DATE(created_at) as fecha, COUNT(*) as cantidad")
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $fechas = $tramitesUltimos7Dias->pluck('fecha')->map(function ($fecha) {
            return Carbon::parse($fecha)->format('d M');
        });

        $cantidadesPorDia = $tramitesUltimos7Dias->pluck('cantidad');

        return view('admin.panel.index', [
            'totalTramites' => $totalTramites,
            'pendientes' => $pendientes,
            'derivados' => $derivados,
            'rechazados' => $rechazados,
            'atendidos' => $atendidos,
            'totalEstudiantes' => $totalEstudiantes,
            'totalPersonal' => $totalPersonal,
            'fechas' => $fechas,
            'cantidadesPorDia' => $cantidadesPorDia,
        ]);
    }
}
