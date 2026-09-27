<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->enum('tipo', ['video', 'imagen'])->default('imagen');
            $table->string('archivo')->nullable();
            $table->string('url')->nullable();
            $table->string('miniatura')->nullable();
            $table->integer('orden')->default(0);
            $table->boolean('visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
