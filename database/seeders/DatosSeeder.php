<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatosSeeder extends Seeder
{
    public function run(): void
    {
        // Propietarios
        DB::table('propietarios')->insert([
            [
                'nombre'              => 'Carlos Martínez',
                'documento_identidad' => '01234567-8',
                'telefono'            => '7777-1111',
                'correo'              => 'carlos@gmail.com',
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
            [
                'nombre'              => 'Ana López',
                'documento_identidad' => '09876543-2',
                'telefono'            => '7777-2222',
                'correo'              => 'ana@gmail.com',
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
        ]);

        // Vehículos
        DB::table('vehiculos')->insert([
            [
                'placa'          => 'P-123456',
                'marca'          => 'Toyota',
                'modelo'         => 'Corolla',
                'anio'           => 2020,
                'id_propietario' => 1,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
            [
                'placa'          => 'P-654321',
                'marca'          => 'Honda',
                'modelo'         => 'Civic',
                'anio'           => 2019,
                'id_propietario' => 2,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);

        // Mantenimientos
        DB::table('mantenimientos')->insert([
            [
                'fecha_servicio'       => '2024-01-15',
                'descripcion_falla'    => 'Cambio de aceite y filtros',
                'estado'               => 'Completado',
                'costo_mano_obra'      => 25.00,
                'id_vehiculo'          => 1,
                'id_usuario_encargado' => 1, // Vinculado al usuario ID 1
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'fecha_servicio'       => '2024-03-10',
                'descripcion_falla'    => 'Revisión de frenos',
                'estado'               => 'Completado',
                'costo_mano_obra'      => 40.00,
                'id_vehiculo'          => 1,
                'id_usuario_encargado' => 1, // Vinculado al usuario ID 1
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'fecha_servicio'       => '2024-05-20',
                'descripcion_falla'    => 'Cambio de batería',
                'estado'               => 'Completado',
                'costo_mano_obra'      => 15.00,
                'id_vehiculo'          => 2,
                'id_usuario_encargado' => 1, 
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
            [
                'fecha_servicio'       => '2024-06-01',
                'descripcion_falla'    => 'Falla en sistema de enfriamiento',
                'estado'               => 'En Proceso',
                'costo_mano_obra'      => 60.00,
                'id_vehiculo'          => 2,
                'id_usuario_encargado' => 1, 
                'created_at'           => now(),
                'updated_at'           => now(),
            ],
        ]);
    }
}
