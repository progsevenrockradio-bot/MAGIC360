<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'visible' => 'boolean',
            'orden' => 'integer',
        ];
    }
}
