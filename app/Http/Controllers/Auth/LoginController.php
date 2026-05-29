<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UsuarioResource;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        // Buscar al usuario por username 
        $usuario = Usuario::where('username', $request->username)->first();

        // Criterio: Validar credenciales correctas
        if (!$usuario || !Hash::check($request->password, $usuario->password_hash)) {
            
            // Criterio: Registrar el intento fallido en el historial de cambios
            DB::table('historial_cambios')->insert([
                'tipo_evento' => 'LOGIN_FALLIDO',
                'descripcion_evento' => "Intento de inicio de sesión fallido para el usuario: {$request->username}",
                'direccion_ip' => $request->ip(),
                'id_usuario' => $usuario ? $usuario->id_usuario : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Criterio: Mensaje de error sin revelar información sensible
            return response()->json([
                'message' => 'Las credenciales ingresadas son incorrectas.'
            ], 401);
        }

        // Criterio: Impedir el acceso a usuarios deshabilitados
        if (!$usuario->estado_activo) {
            return response()->json([
                'message' => 'Tu cuenta se encuentra suspendida. Contacta al administrador.'
            ], 403);
        }

        // Buscar el rol manualmente con Query Builder para no depender del modelo Rol
        $rol = DB::table('roles')->where('id_rol', $usuario->id_rol)->first();

        // Inyectamos dinámicamente el rol encontrado al objeto usuario temporalmente 
        // para que el UsuarioResource pueda leerlo sin problemas
        $usuario->nombre_rol_temporal = $rol ? $rol->nombre_rol : 'Sin Rol';

        // Generar Token de Acceso con Sanctum
        $token = $usuario->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Autenticación exitosa.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'usuario' => new UsuarioResource($usuario)
        ], 200);
    }
}