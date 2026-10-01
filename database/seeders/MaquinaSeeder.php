<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Maquina;

class MaquinaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Maquina::firstOrCreate(
            ['nombre' => 'Cabina 360 · Principal'],
            [
                'activa' => true,
                'notas' => 'Máquina por defecto'
            ]
        );
    }
}
