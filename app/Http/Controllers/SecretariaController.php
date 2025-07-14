<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tramite;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Storage;

class SecretariaController extends Controller
{
    public function index()
    {
        // Obtener los trámites destinados a Secretaría Académica
        $tramites = Tramite::where('area_destino', 'secretaria_academica')->orderBy('created_at', 'desc')->get();

        // Cambiar el estado a "pendiente" si aún no ha sido marcado como tal
        foreach ($tramites as $tramite) {
    if ($tramite->estado === 'derivado') {
        $tramite->estado = 'pendiente';
        $tramite->save();
    }
}


        return view('panel-secretaria', compact('tramites'));
    }

    public function revisar($id)
    {
        $tramite = Tramite::with('estudiante')->findOrFail($id);
        return view('ver-tramite-secretaria', compact('tramite'));
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
            'mensaje' => 'Tu solicitud de <strong>' . ucwords(str_replace('_', ' ', $tramite->tipo_tramite)) . '</strong> fue atendida por Secretaría Académica.',
            'tipo' => 'atendido',
            'leido' => false,
            'link' => asset('storage/' . $tramite->respuesta),
        ]);

return redirect()->route('panel.secretaria')->with('success', 'Trámite respondido correctamente.');
    }

    public function derivar(Request $request, $id)
    {
        $tramite = Tramite::findOrFail($id);
        $tramite->estado = 'derivado';
        $tramite->respuesta = 'Derivado a: Dirección Académica';
        $tramite->area_destino = 'direccion_academica';
        $tramite->derivado_por = 'secretaria_academica';
        $tramite->fecha_derivacion = now();
        $tramite->save();

        Notificacion::create([
            'estudiante_id' => $tramite->estudiante_id,
            'titulo' => 'Trámite derivado',
            'mensaje' => 'Tu trámite fue derivado a <strong>Dirección Académica</strong> para su evaluación.',
            'tipo' => 'derivado',
            'leido' => false,
            'link' => route('tramite.ver', $tramite->id),
        ]);

        return redirect()->route('panel.secretaria')->with('success', 'Trámite derivado correctamente a Dirección Académica.');
    }

    public function historial(Request $request)
    {
        $estado = $request->query('estado'); // recibe "atendido", "derivado", o null

        $query = \App\Models\Tramite::with('estudiante')
            ->where(function ($q) {
                $q->where('area_destino', 'secretaria_academica')
                ->orWhere('derivado_por', 'secretaria_academica');
            })
            ->whereIn('estado', ['atendido', 'derivado']);

        if ($estado && in_array($estado, ['atendido', 'derivado'])) {
            $query->where('estado', $estado);
        }

        $tramites = $query->orderBy('updated_at', 'desc')->get();

        return view('historial-secretaria', compact('tramites', 'estado'));
    }

}
