<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MesaPartesLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-mesapartes');
    }

    public function login(Request $request)
{
    $request->validate([
        'usuario' => 'required',
        'password' => 'required',
    ]);

    $credentials = $request->only('usuario', 'password');

    if (Auth::guard('mesapartes')->attempt($credentials)) {
        $user = Auth::guard('mesapartes')->user();

        // Redirección según el rol
        switch ($user->rol) {
            case 'mesa_de_partes':
                return redirect()->route('mesapartes.bandeja');
            case 'secretaria_academica':
                return redirect()->route('panel.secretaria');
            case 'direccion_academica':
                return redirect()->route('panel.direccion');
            case 'admin':
                return redirect()->route('admin.panel.index'); // ✅ agrega esta línea
            default:
                Auth::guard('mesapartes')->logout();
                return redirect()->route('login.mesapartes')->withErrors([
                    'usuario' => 'Rol no autorizado.',
                ]);
        }
    }

    return back()->withErrors([
        'usuario' => 'Credenciales Incorrectas',
    ])->withInput();
}


    public function logout()
    {
        Auth::guard('mesapartes')->logout();
        return redirect('/');
    }
}
