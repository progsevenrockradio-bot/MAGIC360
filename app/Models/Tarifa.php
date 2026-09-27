<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'precio_desde' => 'boolean',
            'incluye' => 'array',
            'destacada' => 'boolean',
            'visible' => 'boolean',
            'horas' => 'integer',
            'orden' => 'integer',
        ];
    }
}
