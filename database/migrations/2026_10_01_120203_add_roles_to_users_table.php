<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('rol')->default('empleado');
            $table->boolean('activo')->default(true);
            $table->string('telefono')->nullable();
            $table->timestamp('ultimo_acceso_at')->nullable();
        });

        // Asegurar que el usuario 1 es administrador
        DB::table('users')->where('id', 1)->update([
            'rol' => 'administrador',
            'activo' => true
        ]);
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rol', 'activo', 'telefono', 'ultimo_acceso_at']);
        });
    }
};
