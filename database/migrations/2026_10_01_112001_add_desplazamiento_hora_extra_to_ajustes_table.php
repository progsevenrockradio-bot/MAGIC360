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
        Schema::table('ajustes', function (Blueprint $table) {
            $table->decimal('desplazamiento_hora_extra', 8, 2)->default(30.00)->after('desplazamiento_incluido_km');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ajustes', function (Blueprint $table) {
            $table->dropColumn('desplazamiento_hora_extra');
        });
    }
};
