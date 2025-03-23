<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;

class AuthController extends Controller
{
    /**
    * Muestra el formulario de login
    */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
    * Procesa el formulario de login
    */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['mail' => $request->input('mail'), 'password' => $request->input('contrasenia')])) {
            // Autenticación exitosa
            return redirect()->intended('/'); // Redirigir al dashboard
        }

        // Autenticación fallida
        return back()->withErrors([
            'mail' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    /**
    * Elimina sesión del usuario
    */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
