<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            // Verificar si está activo
            if (!$user->activo) {
                Auth::logout();
                return back()->withErrors(['email' => 'Usuario inactivo.']);
            }

            // Actualizar último login
            $user->last_login_at = now();
            $user->save();

            $request->session()->regenerate();
            return redirect()->intended('/panel');
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.']);
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Mostrar formulario de registro (opcional)
    public function showRegisterForm()
    {
        return view('auth.register'); // si querés permitir registro desde frontend
    }

    // Procesar registro (opcional)
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'tipo_usuario' => 'required|string|in:Administrador A,Administrador B,Vendedor',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tipo_usuario' => $request->tipo_usuario,
            'activo' => true,
        ]);

        // Loguear automáticamente después de registrar
        Auth::login($user);

        return redirect('/panel')->with('success', 'Cuenta creada correctamente.');
    }
}
