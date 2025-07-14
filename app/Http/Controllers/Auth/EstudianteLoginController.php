<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Estudiante;

class EstudianteLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-estudiante');
    }

    public function login(Request $request)
    {
        $request->validate([
            'codigo_estudiante' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('codigo_estudiante', 'password');

        // Intenta autenticar con el guard personalizado
        if (Auth::guard('estudiante')->attempt($credentials)) {
            return redirect()->intended('/panel-estudiante');
        }

        return back()->withErrors([
            'codigo_estudiante' => 'Credenciales Incorrectas',
        ]);
    }

    public function logout()
    {
        Auth::guard('estudiante')->logout();
        return redirect('/');
    }
}
