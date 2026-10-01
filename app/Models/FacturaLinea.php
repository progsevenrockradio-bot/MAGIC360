<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacturaLinea extends Model
{
    use HasFactory;

    protected $fillable = [
        'factura_id',
        'concepto',
        'cantidad',
        'precio_unitario',
        'descuento',
        'subtotal',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class);
    }
}
