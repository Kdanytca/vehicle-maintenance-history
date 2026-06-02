<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ControllerLogin extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            // Regenerar sesión para evitar fijación
            $request->session()->regenerate();

            $user = Auth::user();

            if (!$user->estado_activo) {
                Auth::logout();
                Log::warning('Intento de acceso de usuario deshabilitado', [
                    'username' => $request->username,
                    'ip' => $request->ip()
                ]);
                return back()->withErrors(['login' => 'Credenciales incorrectas o usuario inactivo']);
            }

            $rolNombre = $user->rol->nombre_rol ?? 'mecanico';

            return match ($rolNombre) {
                'admin' => redirect('/auth/admin'),
                'mecanico' => redirect('/auth/mecanico'),
                default => redirect('/dashboard')
            };
        }

        Log::warning('Intento de login fallido', [
            'username' => $request->username,
            'ip' => $request->ip()
        ]);

        return back()->withErrors(['login' => 'Credenciales incorrectas o usuario inactivo']);
    }
}
