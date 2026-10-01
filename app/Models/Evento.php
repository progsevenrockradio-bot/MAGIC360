<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'maquina_id',
        'presupuesto_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'poblacion',
        'direccion',
        'zona_id',
        'horas_servicio',
        'horas_extra_viaje',
        'importe_total',
        'senal_cobrada',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha' => 'date',
        'importe_total' => 'decimal:2',
        'senal_cobrada' => 'decimal:2',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function maquina(): BelongsTo
    {
        return $this->belongsTo(Maquina::class);
    }

    public function presupuesto(): BelongsTo
    {
        return $this->belongsTo(Presupuesto::class);
    }

    public function zona(): BelongsTo
    {
        return $this->belongsTo(Zona::class);
    }

    public function scopeProximos(Builder $query): Builder
    {
        return $query->where('estado', 'reservado')
                     ->where('fecha', '>=', Carbon::today())
                     ->orderBy('fecha', 'asc')
                     ->orderBy('hora_inicio', 'asc');
    }

    public function scopeRealizados(Builder $query): Builder
    {
        return $query->where('estado', 'realizado')
                     ->orderBy('fecha', 'desc');
    }

    public function scopeMesActual(Builder $query): Builder
    {
        return $query->whereMonth('fecha', Carbon::now()->month)
                     ->whereYear('fecha', Carbon::now()->year);
    }
}
