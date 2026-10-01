<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('facturas', function (Blueprint $table) {
            if (! Schema::hasColumn('facturas', 'serie')) {
                $table->string('serie')->nullable();
            }
            if (! Schema::hasColumn('facturas', 'ejercicio')) {
                $table->integer('ejercicio')->nullable();
            }
            if (! Schema::hasColumn('facturas', 'factura_rectificada_id')) {
                $table->foreignId('factura_rectificada_id')->nullable()->constrained('facturas')->nullOnDelete();
            }
            if (! Schema::hasColumn('facturas', 'motivo_rectificacion')) {
                $table->string('motivo_rectificacion')->nullable();
            }
            if (! Schema::hasColumn('facturas', 'base')) {
                $table->decimal('base', 10, 2)->default(0);
            }
            if (! Schema::hasColumn('facturas', 'iva_porcentaje')) {
                $table->decimal('iva_porcentaje', 5, 2)->default(21);
            }
            if (! Schema::hasColumn('facturas', 'iva_importe')) {
                $table->decimal('iva_importe', 10, 2)->default(0);
            }
            if (! Schema::hasColumn('facturas', 'irpf_porcentaje')) {
                $table->decimal('irpf_porcentaje', 5, 2)->default(0);
            }
            if (! Schema::hasColumn('facturas', 'irpf_importe')) {
                $table->decimal('irpf_importe', 10, 2)->default(0);
            }
            if (! Schema::hasColumn('facturas', 'presupuesto_id')) {
                $table->foreignId('presupuesto_id')->nullable()->constrained('presupuestos')->nullOnDelete();
            }
            if (! Schema::hasColumn('facturas', 'fecha_vencimiento')) {
                $table->date('fecha_vencimiento')->nullable();
            }
            if (! Schema::hasColumn('facturas', 'fecha_pago')) {
                $table->date('fecha_pago')->nullable();
            }
            if (! Schema::hasColumn('facturas', 'pdf_generado_at')) {
                $table->timestamp('pdf_generado_at')->nullable();
            }
            if (! Schema::hasColumn('facturas', 'huella')) {
                $table->string('huella')->nullable();
            }
            if (! Schema::hasColumn('facturas', 'huella_anterior')) {
                $table->string('huella_anterior')->nullable();
            }
            if (! Schema::hasColumn('facturas', 'registro_alta_at')) {
                $table->timestamp('registro_alta_at')->nullable();
            }
        });

        Schema::table('ajustes', function (Blueprint $table) {
            if (! Schema::hasColumn('ajustes', 'nombre_fiscal')) {
                $table->string('nombre_fiscal')->nullable();
            }
            if (! Schema::hasColumn('ajustes', 'nif')) {
                $table->string('nif')->nullable();
            }
            if (! Schema::hasColumn('ajustes', 'direccion_fiscal')) {
                $table->string('direccion_fiscal')->nullable();
            }
            if (! Schema::hasColumn('ajustes', 'iban')) {
                $table->string('iban')->nullable();
            }
            if (! Schema::hasColumn('ajustes', 'iva_porcentaje')) {
                $table->decimal('iva_porcentaje', 5, 2)->default(21);
            }
            if (! Schema::hasColumn('ajustes', 'irpf_porcentaje')) {
                $table->decimal('irpf_porcentaje', 5, 2)->default(0);
            }
            if (! Schema::hasColumn('ajustes', 'dias_vencimiento')) {
                $table->integer('dias_vencimiento')->default(30);
            }
        });

        Schema::table('clientes', function (Blueprint $table) {
            if (! Schema::hasColumn('clientes', 'nif')) {
                $table->string('nif')->nullable();
            }
            if (! Schema::hasColumn('clientes', 'direccion')) {
                $table->string('direccion')->nullable();
            }
        });

        Schema::table('presupuestos', function (Blueprint $table) {
            if (! Schema::hasColumn('presupuestos', 'facturado')) {
                $table->boolean('facturado')->default(false);
            }
        });

        if (! Schema::hasTable('factura_lineas')) {
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
    }

    public function down(): void
    {
        // Safe down
    }
};
