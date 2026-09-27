<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'visible' => 'boolean',
            'orden' => 'integer',
        ];
    }
}
