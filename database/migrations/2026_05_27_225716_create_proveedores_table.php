<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id('id_proveedor');
            $table->string('nombre_proveedor', 100)->comment('Nombre o razón social del proveedor');
            $table->string('contacto', 100)->nullable()->comment('Nombre de la persona de contacto');
            $table->string('telefono', 20)->nullable()->comment('Teléfono de atención del proveedor');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};