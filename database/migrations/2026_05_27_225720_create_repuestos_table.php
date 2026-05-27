<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repuestos', function (Blueprint $table) {
            $table->id('id_repuesto');
            $table->string('nombre_pieza', 100)->comment('Nombre comercial del repuesto o pieza');
            $table->decimal('costo_unitario', 10, 2)->comment('Precio de costo de la pieza');
            
            // Llaves foráneas
            $table->unsignedBigInteger('id_mantenimiento')->nullable();
            $table->unsignedBigInteger('id_factura')->nullable();

            $table->foreign('id_mantenimiento')->references('id_mantenimiento')->on('mantenimientos')->onDelete('set null');
            $table->foreign('id_factura')->references('id_factura')->on('facturas')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repuestos');
    }
};