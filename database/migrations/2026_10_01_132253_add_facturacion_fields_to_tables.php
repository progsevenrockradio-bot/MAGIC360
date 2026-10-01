<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            $table->string('serie')->nullable()->after('numero');
            $table->integer('ejercicio')->nullable()->after('serie');
            $table->foreignId('factura_rectificada_id')->nullable()->constrained('facturas')->nullOnDelete()->after('ejercicio');
            $table->string('motivo_rectificacion')->nullable()->after('factura_rectificada_id');
            $table->decimal('base', 10, 2)->default(0)->after('motivo_rectificacion');
            $table->decimal('iva_porcentaje', 5, 2)->default(21)->after('base');
            $table->decimal('iva_importe', 10, 2)->default(0)->after('iva_porcentaje');
            $table->decimal('irpf_porcentaje', 5, 2)->default(0)->after('iva_importe');
            $table->decimal('irpf_importe', 10, 2)->default(0)->after('irpf_porcentaje');
            $table->foreignId('presupuesto_id')->nullable()->constrained('presupuestos')->nullOnDelete()->after('irpf_importe');
            $table->date('fecha_vencimiento')->nullable()->after('fecha');
            $table->date('fecha_pago')->nullable()->after('fecha_vencimiento');
            $table->timestamp('pdf_generado_at')->nullable();
            
            // VeriFactu
            $table->string('huella')->nullable();
            $table->string('huella_anterior')->nullable();
            $table->timestamp('registro_alta_at')->nullable();
        });

        Schema::table('ajustes', function (Blueprint $table) {
            $table->string('nombre_fiscal')->nullable();
            $table->string('nif')->nullable();
            $table->string('direccion_fiscal')->nullable();
            $table->string('iban')->nullable();
            $table->decimal('iva_porcentaje', 5, 2)->default(21);
            $table->decimal('irpf_porcentaje', 5, 2)->default(0);
            $table->integer('dias_vencimiento')->default(30);
        });

        Schema::table('clientes', function (Blueprint $table) {
            $table->string('nif')->nullable();
            $table->string('direccion')->nullable();
        });

        Schema::table('presupuestos', function (Blueprint $table) {
            $table->boolean('facturado')->default(false);
        });
        
        // Tabla de líneas de factura
        Schema::create('factura_lineas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factura_id')->constrained()->cascadeOnDelete();
            $table->string('concepto');
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 10, 2)->default(0);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Safe down
    }
};
