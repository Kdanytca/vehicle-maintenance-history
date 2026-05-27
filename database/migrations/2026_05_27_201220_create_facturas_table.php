<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();

            $table->string('numero_factura')->unique()->comment('Número único de factura');
            $table->string('archivo_pdf')->comment('Ruta del archivo PDF de la factura');
            $table->date('fecha_factura')->comment('Fecha de emisión de la factura');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};