<?php

namespace Database\Factories;

use App\Models\Presupuesto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Presupuesto>
 */
class PresupuestoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'numero' => Presupuesto::generarNumero(),
            'fecha' => now()->toDateString(),
            'fecha_evento' => now()->addDays(20)->toDateString(),
            'cliente_nombre' => fake()->name(),
            'cliente_telefono' => '+34 612 345 678',
            'cliente_email' => fake()->safeEmail(),
            'ciudad' => 'Alicante',
            'tipo_evento' => 'Boda',
            'horas' => 3,
            'zona_id' => null,
            'horas_extra_viaje' => 0,
            'desglose' => [
                'tarifa' => [
                    'nombre' => '3 horas',
                    'horas' => 3,
                    'precio' => 290.00,
                ],
                'recargo_zona' => 0.00,
                'horas_extra_viaje' => [
                    'horas' => 0,
                    'precio_hora' => 30.00,
                    'subtotal' => 0.00,
                ],
                'extras' => [],
                'nocturnidad' => [
                    'aplica' => false,
                    'importe' => 0.00,
                ],
                'total' => 290.00,
            ],
            'total' => 290.00,
            'estado' => 'enviado',
            'notas' => null,
            'validez_dias' => 15,
        ];
    }
}
