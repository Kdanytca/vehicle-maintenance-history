<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vehiculo_id')
                ->constrained('vehiculos')
                ->onDelete('cascade')
                ->comment('Llave foránea al vehículo en mantenimiento');

            $table->text('descripcion')->comment('Descripción del mantenimiento realizado');
            $table->date('fecha_mantenimiento')->comment('Fecha en que se realizó el mantenimiento');

            $table->string('mecanico_responsable')->comment('Nombre del mecánico a cargo');

            $table->enum('estado', [
                'activo',
                'finalizado',
                'cancelado'
            ])->default('activo');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};