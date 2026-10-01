<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ajuste extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'precio_desde' => 'boolean',
            'nocturnidad_activa' => 'boolean',
            'nocturnidad_importe' => 'decimal:2',
            'desplazamiento_incluido_km' => 'integer',
            'desplazamiento_hora_extra' => 'decimal:2',
            'radio_activa' => 'boolean',
        ];
    }
}
