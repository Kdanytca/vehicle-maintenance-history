<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('placa')->unique()->comment('Placa única del vehículo');
            $table->string('marca');
            $table->string('modelo');
            $table->integer('anio')->comment('Año de fabricación del vehículo');

            $table->foreignId('propietario_id')
                ->constrained('propietarios')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};