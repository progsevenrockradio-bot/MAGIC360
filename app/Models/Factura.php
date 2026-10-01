<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'cliente_id',
        'evento_id',
        'fecha_emision',
        'base',
        'iva_porcentaje',
        'iva_importe',
        'irpf_porcentaje',
        'irpf_importe',
        'total',
        'estado',
        'notas',
        'pdf_generado_at',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'base' => 'decimal:2',
        'iva_porcentaje' => 'decimal:2',
        'iva_importe' => 'decimal:2',
        'irpf_porcentaje' => 'decimal:2',
        'irpf_importe' => 'decimal:2',
        'total' => 'decimal:2',
        'pdf_generado_at' => 'datetime',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }
}
