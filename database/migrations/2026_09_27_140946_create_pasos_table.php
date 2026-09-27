<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasos', function (Blueprint $table) {
            $table->id();
            $table->integer('numero');
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('icono')->nullable();
            $table->integer('orden')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasos');
    }
};
