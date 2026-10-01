<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Factura extends Model {
    use HasFactory;
    protected \ = [];
    protected \ = [
        'fecha' => 'date',
        'fecha_vencimiento' => 'date',
        'fecha_pago' => 'date',
        'pdf_generado_at' => 'datetime',
        'registro_alta_at' => 'datetime',
    ];
    public function cliente() { return \->belongsTo(Cliente::class); }
    public function evento() { return \->belongsTo(Evento::class); }
    public function lineas() { return \->hasMany(FacturaLinea::class); }
    public function presupuesto() { return \->belongsTo(Presupuesto::class); }
}
