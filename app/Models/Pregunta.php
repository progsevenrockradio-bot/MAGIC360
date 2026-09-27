<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'visible' => 'boolean',
            'orden' => 'integer',
        ];
    }
}
