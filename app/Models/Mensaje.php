<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'fecha_evento' => 'date',
            'atendido' => 'boolean',
            'creado_en' => 'datetime',
        ];
    }
}
