<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id('id_mantenimiento');
            $table->date('fecha_servicio')->comment('Fecha programada o realizada del servicio');
            $table->text('descripcion_falla')->comment('Detalles del problema reportado o trabajo a realizar');
            $table->string('estado', 20)->default('Pendiente')->comment('Estado: Pendiente, Completado, Cancelado (Permanencia lógica)');
            $table->decimal('costo_mano_obra', 10, 2)->default(0.00)->comment('Costo del servicio técnico prestado');
            
            // Llave foránea limpia sin comentarios
            $table->unsignedBigInteger('id_vehiculo')->nullable();
            $table->foreign('id_vehiculo')->references('id_vehiculo')->on('vehiculos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};