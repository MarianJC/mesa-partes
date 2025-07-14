<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tramite;
use App\Models\Estudiante;
use Illuminate\Http\Request;

class AdminTramiteController extends Controller
{
    public function index(Request $request)
    {
        $query = Tramite::with('estudiante');

        // Filtros dinámicos
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('tipo_tramite')) {
            $query->where('tipo_tramite', $request->tipo_tramite);
        }

        if ($request->filled('area_destino')) {
            $query->where('area_destino', $request->area_destino);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('created_at', $request->fecha);
        }

        if ($request->filled('nombre_estudiante')) {
            $query->whereHas('estudiante', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->nombre_estudiante . '%');
            });
        }

        $tramites = $query->orderBy('created_at', 'desc')->paginate(10);

        // 👇 Aquí defines los nombres amigables:
        $nombresAreas = [
            'secretaria_academica' => 'Secretaría Académica',
            'direccion_academica' => 'Dirección Académica',
            'coordinacion_general' => 'Coordinación General',
            'mesa_partes' => 'Mesa de Partes',
            'otro' => 'Otro',
            '-' => '-'
        ];

        return view('admin.tramites.index', compact('tramites', 'nombresAreas'));
    }
}
