<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tramite;

class MesaPartesController extends Controller
{
   public function bandeja()
   {
      $tramites = Tramite::with('estudiante')
        ->whereIn('estado', ['pendiente', 'derivado']) // Solo estos estados
        ->orderBy('created_at', 'desc')
        ->get();

    return view('panel-mesapartes', compact('tramites'));
   }

   public function historial(Request $request)
   {
      $estado = $request->query('estado'); // recibe "derivado", "rechazado", o null

      $query = \App\Models\Tramite::with('estudiante')
                  ->whereIn('estado', ['derivado', 'rechazado']);

      if ($estado && in_array($estado, ['derivado', 'rechazado'])) {
         $query->where('estado', $estado);
      }

      $tramites = $query->orderBy('created_at', 'desc')->get();

      return view('historial-tramites', compact('tramites', 'estado'));
   }

}
