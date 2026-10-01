<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->date('fecha');
            $table->date('fecha_evento')->nullable();
            $table->string('cliente_nombre');
            $table->string('cliente_telefono');
            $table->string('cliente_email');
            $table->string('ciudad')->nullable();
            $table->string('tipo_evento')->nullable();
            $table->integer('horas')->nullable();
            $table->foreignId('zona_id')->nullable()->constrained('zonas')->nullOnDelete();
            $table->integer('horas_extra_viaje')->default(0);
            $table->json('desglose')->nullable();
            $table->decimal('total', 10, 2)->default(0);
            $table->string('estado')->default('enviado'); // borrador, enviado, aceptado, rechazado
            $table->text('notas')->nullable();
            $table->integer('validez_dias')->default(15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presupuestos');
    }
};
