<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('telefono');
            $table->string('email');
            $table->date('fecha_evento')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('tipo_evento')->nullable();
            $table->string('horas')->nullable();
            $table->string('zona')->nullable();
            $table->text('mensaje')->nullable();
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('atendido')->default(false);
            $table->timestamp('creado_en')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
