<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('repuestos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre')->comment('Nombre del repuesto');
            $table->integer('cantidad')->comment('Cantidad disponible o utilizada');
            $table->decimal('precio', 10, 2)->comment('Precio unitario del repuesto');
            $table->date('garantia')->nullable()->comment('Fecha de vencimiento de la garantía');

            //llaves foráneas
            $table->foreignId('mantenimiento_id')
                ->constrained('mantenimientos')
                ->onDelete('cascade');

            $table->foreignId('proveedor_id')
                ->constrained('proveedores')
                ->onDelete('cascade');

            $table->foreignId('factura_id')
                ->nullable()
                ->constrained('facturas')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('repuestos');
    }
};