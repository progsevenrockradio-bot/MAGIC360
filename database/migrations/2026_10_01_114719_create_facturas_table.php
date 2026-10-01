<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('evento_id')->nullable()->constrained('eventos')->nullOnDelete();
            $table->date('fecha_emision');
            $table->decimal('base', 10, 2);
            $table->decimal('iva_porcentaje', 5, 2)->default(21);
            $table->decimal('iva_importe', 10, 2);
            $table->decimal('irpf_porcentaje', 5, 2)->default(0);
            $table->decimal('irpf_importe', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['emitida', 'pagada', 'vencida'])->default('emitida');
            $table->text('notas')->nullable();
            $table->timestamp('pdf_generado_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('facturas');
    }
};
