<?php
namespace App\Services;

use App\Models\Factura;
use App\Models\Ajuste;
use App\Models\Presupuesto;
use Illuminate\Support\Carbon;

class FacturacionService
{
    /**
     * Calcula los totales de una factura basada en sus líneas y porcentajes (IVA, IRPF).
     */
    public function recalcularTotales(Factura $factura): void
    {
        $base = $factura->lineas()->sum('subtotal');
        $iva_importe = round($base * ($factura->iva_porcentaje / 100), 2);
        $irpf_importe = round($base * ($factura->irpf_porcentaje / 100), 2);
        
        $factura->base = $base;
        $factura->iva_importe = $iva_importe;
        $factura->irpf_importe = $irpf_importe;
        $factura->total = $base + $iva_importe - $irpf_importe;
        $factura->save();
    }

    /**
     * Asigna un número definitivo a la factura y la marca como emitida.
     */
    public function emitir(Factura $factura, bool $esRectificativa = false, ?Factura $facturaRectificada = null, ?string $motivo = null): void
    {
        if ($factura->estado === 'emitida' || $factura->estado === 'pagada') {
            throw new \Exception("La factura ya ha sido emitida y es inmutable.");
        }
        
        $ajuste = Ajuste::first();
        if (!$ajuste || empty($ajuste->nif) || empty($ajuste->nombre_fiscal)) {
            throw new \Exception("Faltan datos fiscales en Ajustes (NIF o Nombre Fiscal) para emitir la factura.");
        }

        $ejercicio = now()->year;
        $serie = $esRectificativa ? 'M360-R' : 'M360';
        
        // Find next number
        $lastFactura = Factura::where('serie', $serie)
            ->where('ejercicio', $ejercicio)
            ->orderBy('id', 'desc')
            ->first();
            
        $nextNumber = 1;
        if ($lastFactura && preg_match('/-(\d+)$/', $lastFactura->numero, $matches)) {
            $nextNumber = (int)$matches[1] + 1;
        }
        
        $numeroFormateado = sprintf("%s-%d-%04d", $serie, $ejercicio, $nextNumber);
        
        $factura->serie = $serie;
        $factura->ejercicio = $ejercicio;
        $factura->numero = $numeroFormateado;
        
        if ($esRectificativa) {
            $factura->factura_rectificada_id = $facturaRectificada->id;
            $factura->motivo_rectificacion = $motivo;
        }

        $factura->fecha = now();
        $factura->fecha_vencimiento = now()->addDays($ajuste->dias_vencimiento ?? 30);
        $factura->estado = 'emitida';
        
        // VeriFactu Mock prep
        $factura->registro_alta_at = now();
        $factura->huella = hash('sha256', $factura->numero . $factura->total . $factura->fecha);
        if ($lastFactura) {
            $factura->huella_anterior = $lastFactura->huella;
        }

        $factura->save();
    }

    /**
     * Genera una factura a partir de un presupuesto.
     */
    public function desdePresupuesto(Presupuesto $presupuesto): Factura
    {
        if ($presupuesto->facturado) {
            throw new \Exception("Este presupuesto ya ha sido facturado.");
        }
        
        $ajuste = Ajuste::first();
        
        $factura = Factura::create([
            'cliente_id' => $presupuesto->cliente_id,
            'evento_id' => $presupuesto->evento_id,
            'presupuesto_id' => $presupuesto->id,
            'estado' => 'borrador', // Inicia en borrador
            'iva_porcentaje' => $ajuste->iva_porcentaje ?? 21,
            'irpf_porcentaje' => $ajuste->irpf_porcentaje ?? 0,
        ]);
        
        // Copiar líneas si el presupuesto tuviera una tabla de líneas (aquí simulamos a partir del subtotal o extras)
        // En un caso real iteraríamos las líneas del presupuesto, pero el presupuesto actual guarda total directamente.
        // Simularemos una línea principal.
        $factura->lineas()->create([
            'concepto' => 'Servicio Cabina 360',
            'cantidad' => 1,
            'precio_unitario' => $presupuesto->total,
            'subtotal' => $presupuesto->total
        ]);
        
        $this->recalcularTotales($factura);
        
        $presupuesto->facturado = true;
        $presupuesto->save();
        
        return $factura;
    }
}
