<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('id_factura');
            $table->string('numero_factura', 50)->comment('Número correlativo físico o electrónico de la factura');
            $table->date('fecha_emision')->comment('Fecha en la que se emitió la factura');
            $table->decimal('monto_total', 10, 2)->comment('Costo total reflejado en el documento');
            $table->string('ruta_pdf_almacenamiento', 255)->comment('Ruta del archivo PDF almacenado en el servidor o la nube');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};