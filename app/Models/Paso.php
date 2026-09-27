<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paso extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'numero' => 'integer',
            'orden' => 'integer',
        ];
    }
}
