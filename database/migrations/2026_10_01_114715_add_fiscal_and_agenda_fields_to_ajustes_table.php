<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('ajustes', function (Blueprint $table) {
            $table->string('nombre_fiscal')->nullable();
            $table->string('nif')->nullable();
            $table->string('direccion_fiscal')->nullable();
            $table->string('iban')->nullable();
            $table->integer('margen_montaje_horas')->default(1);
        });
    }

    public function down(): void {
        Schema::table('ajustes', function (Blueprint $table) {
            $table->dropColumn(['nombre_fiscal', 'nif', 'direccion_fiscal', 'iban', 'margen_montaje_horas']);
        });
    }
};
