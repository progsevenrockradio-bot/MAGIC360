<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero',
        'serie',
        'ejercicio',
        'cliente_id',
        'evento_id',
        'presupuesto_id',
        'fecha',
        'fecha_vencimiento',
        'fecha_pago',
        'base',
        'iva_porcentaje',
        'iva_importe',
        'irpf_porcentaje',
        'irpf_importe',
        'total',
        'estado',
        'notas',
        'pdf_generado_at',
        'factura_rectificada_id',
        'motivo_rectificacion',
        'huella',
        'huella_anterior',
        'registro_alta_at',
    ];

    protected $casts = [
        'fecha' => 'date',
        'fecha_vencimiento' => 'date',
        'fecha_pago' => 'date',
        'pdf_generado_at' => 'datetime',
        'registro_alta_at' => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function lineas()
    {
        return $this->hasMany(FacturaLinea::class);
    }

    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }

    public function facturaRectificada()
    {
        return $this->belongsTo(Factura::class, 'factura_rectificada_id');
    }
}
