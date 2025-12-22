<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); //vista login.blade.php
    }

   public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'password' => 'required',
        ]);

        // Permitir login por nombre o email
        $credentials = [
            filter_var($request->usuario, FILTER_VALIDATE_EMAIL) ? 'email' : 'name' => $request->usuario,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Redirigir según rol
            if ($user->rol === 'admin') {
                // Redirigir a la vista de formularios del administrador
                return redirect()->route('formulario.lista');
            } else {
                // Redirigir a la página de inicio del usuario normal
                return redirect()->route('formulario.lista');
            }

        }

        return back()->with('error', 'Usuario o contraseña incorrectos.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}


