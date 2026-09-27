<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('horas')->nullable();
            $table->decimal('precio', 8, 2)->nullable();
            $table->boolean('precio_desde')->default(false);
            $table->json('incluye')->nullable();
            $table->boolean('destacada')->default(false);
            $table->integer('orden')->default(0);
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
};
