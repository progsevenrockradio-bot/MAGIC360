<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->foreignId('creado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('modificado_por')->nullable()->constrained('users')->nullOnDelete();
        });
        Schema::table('eventos', function (Blueprint $table) {
            $table->foreignId('creado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('modificado_por')->nullable()->constrained('users')->nullOnDelete();
        });
        Schema::table('facturas', function (Blueprint $table) {
            $table->foreignId('creado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('modificado_por')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropForeign(['creado_por']);
            $table->dropForeign(['modificado_por']);
            $table->dropColumn(['creado_por', 'modificado_por']);
        });
        Schema::table('eventos', function (Blueprint $table) {
            $table->dropForeign(['creado_por']);
            $table->dropForeign(['modificado_por']);
            $table->dropColumn(['creado_por', 'modificado_por']);
        });
        Schema::table('facturas', function (Blueprint $table) {
            $table->dropForeign(['creado_por']);
            $table->dropForeign(['modificado_por']);
            $table->dropColumn(['creado_por', 'modificado_por']);
        });
    }
};
