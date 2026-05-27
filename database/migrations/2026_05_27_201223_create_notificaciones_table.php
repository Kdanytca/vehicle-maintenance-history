<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('correo_destino')->comment('Correo electrónico del destinatario');

            $table->string('asunto')->comment('Asunto de la notificación');
            $table->text('mensaje')->comment('Contenido del mensaje');

            $table->enum('estado', [
                'enviado',
                'error'
            ])->default('enviado')->comment('Estado del envío de la notificación');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};