<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar tablas
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Usuario::truncate();
        Rol::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        // 1. Crear roles
        $rolAdmin = Rol::create([
            'nombre_rol' => 'admin',
            'descripcion' => 'Administrador del sistema'
        ]);

        $rolMecanico = Rol::create([
            'nombre_rol' => 'mecanico',
            'descripcion' => 'Mecánico del taller'
        ]);

        // 2. Crear usuarios
        Usuario::create([
            'username' => 'admin',
            'password_hash' => Hash::make('12345678'),
            'estado_activo' => true,
            'id_rol' => $rolAdmin->id_rol,
        ]);

        Usuario::create([
            'username' => 'mecanico',
            'password_hash' => Hash::make('12345678'),
            'estado_activo' => true,
            'id_rol' => $rolMecanico->id_rol,
        ]);

        Usuario::create([
            'username' => 'suspendido',
            'password_hash' => Hash::make('12345678'),
            'estado_activo' => false,
            'id_rol' => $rolMecanico->id_rol,
        ]);
    }
}