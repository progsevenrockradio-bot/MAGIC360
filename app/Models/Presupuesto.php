<?php

namespace App\Models;

use Database\Factories\PresupuestoFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    /** @use HasFactory<PresupuestoFactory> */
    use HasFactory;

    protected $guarded = [];

    protected static function booted(): void
    {
        static::creating(function (Presupuesto $presupuesto) {
            if (empty($presupuesto->numero)) {
                $presupuesto->numero = static::generarNumero();
            }
            if (empty($presupuesto->fecha)) {
                $presupuesto->fecha = now()->toDateString();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'fecha_evento' => 'date',
            'horas' => 'integer',
            'horas_extra_viaje' => 'integer',
            'desglose' => 'array',
            'total' => 'decimal:2',
            'validez_dias' => 'integer',
        ];
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public static function generarNumero(): string
    {
        $year = date('Y');
        $prefix = "M360-{$year}-";

        $latest = static::where('numero', 'like', "{$prefix}%")
            ->orderByDesc('id')
            ->value('numero');

        if ($latest && preg_match('/M360-\d{4}-(\d+)/', $latest, $matches)) {
            $seq = ((int) $matches[1]) + 1;
        } else {
            $seq = 1;
        }

        return sprintf('M360-%s-%04d', $year, $seq);
    }

    public function getFechaValidezAttribute()
    {
        if (! $this->fecha) {
            return null;
        }

        return $this->fecha->copy()->addDays($this->validez_dias ?? 15);
    }
}
