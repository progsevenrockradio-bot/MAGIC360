<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonio extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'estrellas' => 'integer',
            'visible' => 'boolean',
            'orden' => 'integer',
        ];
    }
}
