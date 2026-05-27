<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre completo del usuario');
            $table->string('usuario')->unique()->comment('Nombre de usuario único para login');
            $table->string('email')->unique()->comment('Correo electrónico único del usuario');
            $table->string('password')->comment('Contraseña hasheada del usuario');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo')->comment('Estado del usuario: activo o inactivo');

            $table->foreignId('role_id')
                ->constrained('roles')
                ->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};