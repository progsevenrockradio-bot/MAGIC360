<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'recargo' => 'decimal:2',
            'a_consultar' => 'boolean',
            'visible' => 'boolean',
            'orden' => 'integer',
        ];
    }
}
