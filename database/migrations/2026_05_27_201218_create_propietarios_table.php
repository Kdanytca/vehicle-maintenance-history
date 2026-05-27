<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('propietarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre completo del propietario');
            $table->string('telefono')->nullable()->comment('Número de teléfono de contacto');
            $table->string('correo')->nullable()->comment('Correo electrónico del propietario');
            $table->text('direccion')->nullable()->comment('Dirección de residencia del propietario');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('propietarios');
    }
};