<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Personal; // Asegúrate de importar el modelo

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $personales = Personal::all(); // Obtener todos los registros
        return view('admin.personales.index', compact('personales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.personales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:100|unique:personales',
            'nombre' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required|in:mesa_de_partes,secretaria_academica,direccion_academica,admin',
            'correo' => 'nullable|email|max:255',
            'dni' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
        ]);

        Personal::create([
            'usuario' => $request->usuario,
            'nombre' => $request->nombre,
            'password' => Hash::make($request->password),
            'rol' => $request->rol,
            'correo' => $request->correo,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('admin.personales.create')->with('success', 'Personal creado correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $personal = Personal::findOrFail($id);
        return view('admin.personales.edit', compact('personal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $personal = Personal::findOrFail($id);

        $request->validate([
            'usuario' => 'required|string|max:255|unique:personales,usuario,' . $id,
            'nombre' => 'required|string|max:255',
            'correo' => 'nullable|email|max:255|unique:personales,correo,' . $id,
            'rol' => 'required|in:mesa_de_partes,secretaria_academica,direccion_academica,admin',
            'dni' => 'nullable|string|max:15',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Actualizar campos generales
        $personal->update([
            'usuario' => $request->usuario,
            'nombre' => $request->nombre,
            'correo' => $request->correo,
            'rol' => $request->rol,
            'dni' => $request->dni,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
        ]);

        // Actualizar contraseña si se ingresó una nueva
        if ($request->filled('password')) {
            $personal->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->back()->with('success', 'Datos del personal actualizados correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personal = Personal::findOrFail($id);
        $personal->delete();

        return redirect()->route('admin.personales.index')->with('success', 'Personal eliminado');
    }
}
