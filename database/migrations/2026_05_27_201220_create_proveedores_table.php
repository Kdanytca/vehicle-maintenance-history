<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();

            $table->string('nombre')->comment('Nombre del proveedor');
            $table->string('correo')->nullable()->comment('Correo electrónico de contacto');
            $table->string('telefono')->nullable()->comment('Número de teléfono de contacto');
            $table->text('direccion')->nullable()->comment('Dirección del proveedor');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};