<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EstudianteController extends Controller
{
    private function asegurarRolAdmin()
    {
        $usuario = auth()->guard('mesapartes')->user();
        if ($usuario->rol !== 'admin') {
            abort(403, 'Acceso no autorizado');
        }
    }

    public function index()
    {
        $this->asegurarRolAdmin();
        $estudiantes = Estudiante::all();
        return view('admin.estudiantes.index', compact('estudiantes'));
    }

    public function create()
    {
        $this->asegurarRolAdmin();
        return view('admin.estudiantes.create');
    }

    public function store(Request $request)
    {
        $this->asegurarRolAdmin();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:estudiantes',
            'password' => 'required|min:6|confirmed',
            'especialidad' => 'required|string|max:100',
            'dni' => 'required|string|max:15',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:masculino,femenino',
        ]);

        Estudiante::create([
            'codigo_estudiante' => Estudiante::generarCodigoEstudiante(),
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'especialidad' => $request->especialidad,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
        ]);

        return redirect()->route('admin.estudiantes.create')->with('success', 'Estudiante creado correctamente');
    }

    public function edit($id)
    {
        $this->asegurarRolAdmin();
        $estudiante = Estudiante::findOrFail($id);
        return view('admin.estudiantes.edit', compact('estudiante'));
    }

    public function update(Request $request, $id)
    {
        $this->asegurarRolAdmin();

        $estudiante = Estudiante::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:estudiantes,correo,' . $id,
            'especialidad' => 'required|string|max:100',
            'dni' => 'required|string|max:15',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'genero' => 'required|in:masculino,femenino,otro',
            'password' => 'nullable|min:6|confirmed', // ✔️ contraseña opcional
        ]);

        // Actualizar datos generales
        $estudiante->update([
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'especialidad' => $request->especialidad,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
        ]);

        // Si el campo contraseña no está vacío, se actualiza
        if ($request->filled('password')) {
            $estudiante->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->back()->with('success', 'Estudiante actualizado correctamente.');
    }

    public function destroy($id)
    {
        $this->asegurarRolAdmin();

        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();

        return redirect()->route('admin.estudiantes.index')->with('success', 'Estudiante eliminado');
    }
}
