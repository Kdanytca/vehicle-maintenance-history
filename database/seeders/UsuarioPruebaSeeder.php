<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioPruebaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insertar un rol base directo con Query Builder (evita usar el modelo Rol)
        DB::table('roles')->insertOrIgnore([
            'id_rol' => 1,
            'nombre_rol' => 'Administrador',
            'descripcion' => 'Acceso total al sistema',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Insertar el usuario de prueba vinculado a ese rol
        DB::table('usuarios')->insertOrIgnore([
            'id_usuario' => 1,
            'username' => 'admin_taller',
            'password_hash' => Hash::make('Admin123*'), // Contraseña encriptada para Hash::check
            'estado_activo' => true,
            'id_rol' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // 3. Insertar un usuario deshabilitado para probar el criterio de aceptación 6
        DB::table('usuarios')->insertOrIgnore([
            'id_usuario' => 2,
            'username' => 'mecanico_suspendido',
            'password_hash' => Hash::make('Mecanico123*'),
            'estado_activo' => false, // Deshabilitado
            'id_rol' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}