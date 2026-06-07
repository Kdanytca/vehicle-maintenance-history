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
                'nombre'            => 'Carlos Martínez',
                'documento_identidad' => '01234567-8',
                'telefono'          => '7777-1111',
                'correo'            => 'carlos@gmail.com',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'nombre'            => 'Ana López',
                'documento_identidad' => '09876543-2',
                'telefono'          => '7777-2222',
                'correo'            => 'ana@gmail.com',
                'created_at'        => now(),
                'updated_at'        => now(),
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
                'fecha_servicio'      => '2024-01-15',
                'descripcion_falla'   => 'Cambio de aceite y filtros',
                'mecanico_responsable' => 'Juan Pérez',
                'estado'              => 'completado',
                'costo_mano_obra'     => 25.00,
                'id_vehiculo'         => 1,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
            [
                'fecha_servicio'      => '2024-03-10',
                'descripcion_falla'   => 'Revisión de frenos',
                'mecanico_responsable' => 'Juan Pérez',
                'estado'              => 'completado',
                'costo_mano_obra'     => 40.00,
                'id_vehiculo'         => 1,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
            [
                'fecha_servicio'      => '2024-05-20',
                'descripcion_falla'   => 'Cambio de batería',
                'mecanico_responsable' => 'Mario Ramos',
                'estado'              => 'completado',
                'costo_mano_obra'     => 15.00,
                'id_vehiculo'         => 2,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
            [
                'fecha_servicio'      => '2024-06-01',
                'descripcion_falla'   => 'Falla en sistema de enfriamiento',
                'mecanico_responsable' => 'Mario Ramos',
                'estado'              => 'en_proceso',
                'costo_mano_obra'     => 60.00,
                'id_vehiculo'         => 2,
                'created_at'          => now(),
                'updated_at'          => now(),
            ],
        ]);
    }
}