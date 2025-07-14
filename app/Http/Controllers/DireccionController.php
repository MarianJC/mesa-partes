<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tramite;
use App\Models\Notificacion;

class DireccionController extends Controller
{
    public function index()
    {
        $tramites = Tramite::with('estudiante')
            ->where('area_destino', 'direccion_academica')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($tramites as $tramite) {
            if ($tramite->estado === 'derivado') {
                $tramite->estado = 'pendiente';
                $tramite->save();
            }
        }

        return view('panel-direccion', compact('tramites'));
    }

    public function revisar($id)
    {
        $tramite = Tramite::with('estudiante')->findOrFail($id);
        return view('ver-tramite-direccion', compact('tramite'));
    }

    public function atender(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required|file|mimes:pdf|max:2048',
        ]);

        $tramite = Tramite::findOrFail($id);
        $archivo = $request->file('respuesta');
        $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
        $ruta = $archivo->storeAs('respuestas', $nombreArchivo, 'public');

        $tramite->respuesta = $ruta;
        $tramite->estado = 'atendido';
        $tramite->save();

        Notificacion::create([
            'estudiante_id' => $tramite->estudiante_id,
            'titulo' => 'Trámite atendido',
            'mensaje' => 'Tu trámite fue atendido por Dirección Académica',
            'tipo' => 'atendido',
            'leido' => false,
            'link' => asset('storage/' . $tramite->respuesta),
        ]);

        return redirect()->route('panel.direccion')->with('success', 'Trámite atendido correctamente');
    }

    public function reasignar($id)
    {
        $tramite = Tramite::findOrFail($id);

        // Actualiza el estado correctamente como "reasignado"
        $tramite->estado = 'reasignado';
        $tramite->area_origen = 'direccion_academica'; // Asegúrate de tener esta columna en la tabla
        $tramite->area_destino = 'secretaria_academica';
        $tramite->fecha_derivacion = now();
        $tramite->save();

        // Crear notificación para el estudiante
        Notificacion::create([
            'estudiante_id' => $tramite->estudiante_id,
            'titulo' => 'Trámite redirigido',
            'mensaje' => 'Tu trámite fue reenviado a Secretaría Académica para una mejor evaluación.',
            'tipo' => 'informativo',
            'leido' => false,
            'link' => route('tramite.detalle.estudiante', $tramite->id),
        ]);

        return redirect()->route('panel.direccion')->with('success', 'Trámite reasignado a Secretaría Académica');
    }

    public function historial(Request $request)
    {
        $estado = $request->query('estado');

        $query = \App\Models\Tramite::with('estudiante')
            ->where(function ($query) {
                $query->where('area_destino', 'direccion_academica')
                    ->orWhere('area_origen', 'direccion_academica');
            })
            ->whereIn('estado', ['atendido', 'reasignado']);

        if ($estado && in_array($estado, ['atendido', 'reasignado'])) {
            $query->where('estado', $estado);
        }

        $tramites = $query->orderBy('updated_at', 'desc')->get();

        return view('historial-direccion', compact('tramites', 'estado'));
    }

}
