<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'telefono',
        'email',
        'poblacion',
        'direccion',
        'nif',
        'notas',
    ];

    public function presupuestos(): HasMany
    {
        return $this->hasMany(Presupuesto::class);
    }

    public function eventos(): HasMany
    {
        return $this->hasMany(Evento::class);
    }

    public function facturas(): HasMany
    {
        return $this->hasMany(Factura::class);
    }

    public static function desdeContacto(array $datos): self
    {
        // Find existing by email or phone
        $query = static::query();

        if (!empty($datos['email'])) {
            $query->where('email', $datos['email']);
        }

        if (!empty($datos['telefono'])) {
            // Very basic phone normalization (remove spaces, dashes)
            $phone = preg_replace('/[^0-9+]/', '', $datos['telefono']);
            if (empty($datos['email'])) {
                $query->where('telefono', 'like', "%{$phone}%");
            } else {
                $query->orWhere('telefono', 'like', "%{$phone}%");
            }
        }

        $cliente = $query->first();

        if ($cliente) {
            // Update missing fields if needed, but for now we just return it
            return $cliente;
        }

        return static::create([
            'nombre' => $datos['nombre'] ?? 'Cliente sin nombre',
            'telefono' => $datos['telefono'] ?? null,
            'email' => $datos['email'] ?? null,
            'poblacion' => $datos['poblacion'] ?? null,
        ]);
    }
}
