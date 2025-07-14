<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Auth;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacion::where('estudiante_id', Auth::guard('estudiante')->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notificaciones', compact('notificaciones'));
    }

    public function marcarLeida($id)
    {
        $noti = Notificacion::findOrFail($id);
        if ($noti->estudiante_id == Auth::guard('estudiante')->id()) {
            $noti->leido = true;
            $noti->save();
        }

        return back();
    }

    public function destroy($id)
    {
        $noti = Notificacion::findOrFail($id);
        $noti->delete();

        return redirect()->back()->with('success', 'Notificación eliminada correctamente');
    }

}
