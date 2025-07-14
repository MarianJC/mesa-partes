<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Tramite;
use App\Models\Notificacion;
use Carbon\Carbon;

class TramiteController extends Controller
{
    public function mostrarFormulario($tipo)
    {
        $tiposValidos = [
            'reserva_matricula',
            'cambio_turno',
            'reingreso',
            'reporte_notas',
            'cambio_especialidad',
            'ranking_notas'
        ];

        if (!in_array($tipo, $tiposValidos)) {
            abort(404);
        }

        return view('formulario-tramite', compact('tipo'));
    }

    public function tramitesEnviados(Request $request)
    {
        $estudiante = Auth::guard('estudiante')->user();

        $query = Tramite::where('estudiante_id', $estudiante->id);

        if ($request->filled('codigo')) {
            $query->where('codigo_seguimiento', 'LIKE', '%' . $request->codigo . '%');
        }

        $tramites = $query->orderBy('created_at', 'desc')->get();

        return view('tramites-enviados', compact('tramites'));
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'especialidad' => 'required',
            'dni' => 'required',
            'correo' => 'required|email',
            'descripcion' => 'nullable',
            'archivo' => 'required|mimes:pdf|max:20480',
        ]);

        $estudiante = Auth::guard('estudiante')->user();

        $original = $request->file('archivo')->getClientOriginalName();
        $nombreArchivo = time() . '_' . $original;

        $archivoPath = $request->file('archivo')->storeAs('tramites', $nombreArchivo, 'public');

        $tramite = new Tramite();
        $tramite->estudiante_id = $estudiante->id;
        $tramite->tipo_tramite = $request->input('tipo_tramite');
        $tramite->especialidad = $request->input('especialidad');
        $tramite->dni = $request->input('dni');
        $tramite->correo = $request->input('correo');
        $tramite->descripcion = $request->input('descripcion');
        $tramite->archivo = 'tramites/' . $nombreArchivo;
        $tramite->estado = 'pendiente';
        $tramite->codigo_seguimiento = strtoupper(uniqid('PPD-')); 

        $tramite->save();

        return redirect()->route('panel-estudiante')->with('success', 'Trámite enviado correctamente. Tu código de seguimiento es: ' . $tramite->codigo_seguimiento);

    }

    public function revisar($id)
    {
        $tramite = Tramite::with('estudiante')->findOrFail($id);

        return view('revisar-tramite', compact('tramite'));
    }

    public function derivar(Request $request, $id)
    {
        $request->validate([
            'destino' => 'required|in:secretaria_academica,direccion_academica',
        ]);

        $tramite = \App\Models\Tramite::findOrFail($id);
        $tramite->estado = 'derivado';
        $tramite->respuesta = 'Derivado a: ' . str_replace('_', ' ', $request->destino);
        $tramite->area_destino = $request->destino;
        $tramite->fecha_derivacion = Carbon::now();
        $tramite->save();

        \App\Models\Notificacion::create([
            'estudiante_id' => $tramite->estudiante_id,
            'titulo' => 'Trámite derivado',
            'mensaje' => 'Tu trámite fue derivado a <strong>' . ucwords(str_replace('_', ' ', $request->destino)) . '</strong> para su evaluación.',
            'tipo' => 'derivado',
            'leido' => false,
            'link' => route('tramite.ver', $tramite->id),
        ]);

        return redirect()->route('mesapartes.bandeja')->with('success', 'Trámite derivado correctamente.');
    }

    public function rechazar($id, Request $request)
    {
        $request->validate([
            'respuesta' => 'required|string|max:1000'
        ]);

        $tramite = Tramite::findOrFail($id);
        $tramite->estado = 'rechazado';
        $tramite->respuesta = $request->input('respuesta');
        $tramite->fecha_rechazo = Carbon::now();
        $tramite->save();

        Notificacion::create([
            'estudiante_id' => $tramite->estudiante_id,
            'titulo' => 'Trámite rechazado',
            'mensaje' => 'Tu solicitud de <strong>' . ucwords(str_replace('_', ' ', $tramite->tipo_tramite)) . '</strong> fue rechazada.',
            'tipo' => 'rechazado',
            'leido' => false,
            'link' => route('tramite.ver', $tramite->id),
        ]);

        return redirect()->route('mesapartes.bandeja')->with('success', 'Trámite rechazado correctamente.');
    }

    public function atender(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required|mimes:pdf|max:20480'
        ]);

        $tramite = Tramite::findOrFail($id);

        $nombreArchivo = time() . '_respuesta.pdf';
        $ruta = $request->file('respuesta')->storeAs('respuestas', $nombreArchivo, 'public');

        $tramite->estado = 'atendido';
        $tramite->respuesta = 'respuestas/' . $nombreArchivo;
        $tramite->save();

        Notificacion::create([
            'estudiante_id' => $tramite->estudiante_id,
            'titulo' => 'Trámite atendido',
            'mensaje' => 'Tu solicitud de <strong>' . ucwords(str_replace('_', ' ', $tramite->tipo_tramite)) . '</strong> fue atendida.',
            'tipo' => 'atendido',
            'leido' => false,
            'link' => asset('storage/' . $tramite->respuesta),
        ]);

        return redirect()->route('mesapartes.bandeja')->with('success', 'Trámite atendido y respuesta enviada.');
    }

    public function detalle($id)
    {
        $t = \App\Models\Tramite::with('estudiante')->findOrFail($id);

        $areas = [
            'secretaria_academica' => 'Secretaría Académica',
            'direccion_academica' => 'Dirección Académica',
        ];

        return response()->json([
            'nombre' => $t->estudiante->nombre,
            'codigo' => $t->estudiante->codigo_estudiante,
            'tipo' => ucwords(str_replace('_', ' ', $t->tipo_tramite)),
            'estado' => $t->estado,
            'fecha' => $t->created_at->format('d/m/Y H:i'),
            'fecha_derivacion' => optional($t->fecha_derivacion)->format('d/m/Y H:i'),
            'fecha_rechazo' => optional($t->fecha_rechazo)->format('d/m/Y H:i'),
            'respuesta' => $t->respuesta ?? '',
            'area' => $areas[$t->area_destino] ?? '-',
        ]);
    }

    public function formSeguimiento(Request $request)
    {
        $tramite = null;

        if ($request->has('codigo')) {
            $tramite = \App\Models\Tramite::where('codigo_seguimiento', $request->codigo)->first();
        }

        return view('welcome', compact('tramite'));
    }

    public function detalleEstudiante($id)
    {
        $t = \App\Models\Tramite::with('estudiante')->findOrFail($id);

        return response()->json([
            'tipo' => ucwords(str_replace('_', ' ', $t->tipo_tramite)),
            'fecha' => $t->created_at->format('d/m/Y H:i'),
            'especialidad' => $t->especialidad,
            'dni' => $t->dni,
            'correo' => $t->correo,
            'descripcion' => $t->descripcion ?? '—',
            'estado' => ucfirst($t->estado),
            'archivo' => asset('storage/' . $t->archivo),
        ]);
    }
}
