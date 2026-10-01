<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maquina extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'activa',
        'notas',
    ];

    protected $casts = [
        'activa' => 'boolean',
    ];

    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class);
    }
}
