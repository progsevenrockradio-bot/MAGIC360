<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user for Filament
        User::firstOrCreate(
            ['email' => 'admin@magic360.es'],
            [
                'name' => 'Admin Magic360',
                'password' => Hash::make('magic360password'),
                'email_verified_at' => now(),
            ]
        );

        $this->call(ContenidoInicialSeeder::class);
    }
}
