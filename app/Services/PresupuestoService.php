<?php

namespace App\Services;

use App\Models\Ajuste;
use App\Models\Extra;
use App\Models\Tarifa;
use App\Models\Zona;

class PresupuestoService
{
    /**
     * Calcula el presupuesto completo a partir de los datos proporcionados.
     *
     * @param  array{
     *     horas?: int|string|null,
     *     tarifa_id?: int|null,
     *     zona_id?: int|string|null,
     *     zona?: string|null,
     *     horas_extra_viaje?: int|null,
     *     extras?: array<int|string>|null,
     *     nocturnidad?: bool|int|string|null,
     *     hora_fin?: string|null
     * }  $datos
     * @return array<string, mixed>
     */
    public function calcular(array $datos): array
    {
        $ajuste = Ajuste::firstOrCreate(['id' => 1]);

        // 1. Resolver Horas y Tarifa de Servicio
        $horas = isset($datos['horas']) ? (int) preg_replace('/[^0-9]/', '', (string) $datos['horas']) : null;
        if ($horas === null || $horas <= 0) {
            $horas = 2; // Por defecto 2 horas
        }

        $tarifaExacta = Tarifa::where('visible', true)
            ->where('horas', $horas)
            ->first();

        // Precio por hora extra de servicio (si no hay tarifa exacta o sobrepasa)
        $tarifaExtra = Tarifa::where('visible', true)
            ->whereNull('horas')
            ->where('nombre', 'like', '%extra%')
            ->first();
        $precioHoraExtraServicio = (float) ($tarifaExtra?->precio ?? 60.00);

        if ($tarifaExacta) {
            $tarifaBase = $tarifaExacta;
            $tarifaNombre = $tarifaExacta->nombre;
            $precioBase = (float) $tarifaExacta->precio;
            $horasExtraServicio = 0;
            $tarifaSubtotal = $precioBase;
        } else {
            // Buscar tarifa inferior más cercana
            $tarifaInferior = Tarifa::where('visible', true)
                ->whereNotNull('horas')
                ->where('horas', '<', $horas)
                ->orderByDesc('horas')
                ->first();

            if ($tarifaInferior) {
                $tarifaBase = $tarifaInferior;
                $tarifaNombre = "{$horas} horas ({$tarifaInferior->nombre} + extra)";
                $precioBase = (float) $tarifaInferior->precio;
                $horasExtraServicio = $horas - $tarifaInferior->horas;
                $tarifaSubtotal = $precioBase + ($horasExtraServicio * $precioHoraExtraServicio);
            } else {
                // Si no hay inferior (ej. horas menores a la tarifa mínima), tomar la más pequeña disponible
                $tarifaMenor = Tarifa::where('visible', true)
                    ->whereNotNull('horas')
                    ->orderBy('horas')
                    ->first();
                $tarifaBase = $tarifaMenor;
                $tarifaNombre = $tarifaMenor ? "{$horas} horas" : 'Servicio estándar';
                $precioBase = (float) ($tarifaMenor?->precio ?? 140.00);
                $horasExtraServicio = 0;
                $tarifaSubtotal = $precioBase;
            }
        }

        // 2. Zona y recargo de desplazamiento
        $zona = null;
        if (! empty($datos['zona_id'])) {
            $zona = is_numeric($datos['zona_id'])
                ? Zona::find($datos['zona_id'])
                : Zona::where('nombre', $datos['zona_id'])->first();
        } elseif (! empty($datos['zona'])) {
            $zona = is_numeric($datos['zona'])
                ? Zona::find($datos['zona'])
                : Zona::where('nombre', $datos['zona'])->first();
        }

        $aConsultar = false;
        $recargoZona = 0.00;

        if ($zona) {
            if ($zona->a_consultar) {
                $aConsultar = true;
                $recargoZona = 0.00;
            } else {
                $recargoZona = (float) $zona->recargo;
            }
        }

        // 3. Horas extra de viaje / espera
        $horasExtraViaje = max(0, (int) ($datos['horas_extra_viaje'] ?? 0));
        $precioHoraExtraViaje = (float) ($ajuste->desplazamiento_hora_extra ?? 30.00);
        $subtotalHorasExtraViaje = $horasExtraViaje * $precioHoraExtraViaje;

        // 4. Extras seleccionados
        $extrasList = [];
        $extrasSubtotal = 0.00;
        $extrasIds = $datos['extras'] ?? [];

        if (! empty($extrasIds) && is_array($extrasIds)) {
            // Filtrar IDs numéricos o modelos
            $cleanIds = [];
            foreach ($extrasIds as $item) {
                if (is_numeric($item)) {
                    $cleanIds[] = (int) $item;
                } elseif (is_array($item) && isset($item['id'])) {
                    $cleanIds[] = (int) $item['id'];
                }
            }

            if (! empty($cleanIds)) {
                $extrasModels = Extra::whereIn('id', $cleanIds)->get();
                foreach ($extrasModels as $extraModel) {
                    $precioExtra = (float) ($extraModel->precio ?? 0);
                    $extrasSubtotal += $precioExtra;
                    $extrasList[] = [
                        'id' => $extraModel->id,
                        'nombre' => $extraModel->nombre,
                        'precio' => $precioExtra,
                    ];
                }
            }
        }

        // 5. Nocturnidad
        $aplicaNocturnidad = false;
        if ($ajuste->nocturnidad_activa) {
            if (! empty($datos['nocturnidad']) && filter_var($datos['nocturnidad'], FILTER_VALIDATE_BOOLEAN)) {
                $aplicaNocturnidad = true;
            } elseif (! empty($datos['hora_fin'])) {
                $horaFin = trim((string) $datos['hora_fin']);
                $desdeHora = $ajuste->nocturnidad_desde_hora ?? '00:00';

                // Si hora_fin está en formato HH:MM
                // En eventos nocturnos, terminar a las 00:00 o después (hasta las 08:00) es nocturnidad
                if ($horaFin >= $desdeHora || ($horaFin >= '00:00' && $horaFin <= '08:00')) {
                    $aplicaNocturnidad = true;
                }
            }
        }
        $nocturnidadImporte = $aplicaNocturnidad ? (float) ($ajuste->nocturnidad_importe ?? 50.00) : 0.00;

        // 6. Total
        $total = $tarifaSubtotal + $recargoZona + $subtotalHorasExtraViaje + $extrasSubtotal + $nocturnidadImporte;

        return [
            'tarifa' => [
                'id' => $tarifaBase?->id,
                'nombre' => $tarifaNombre,
                'horas' => $horas,
                'precio_base' => $precioBase,
                'horas_extra' => $horasExtraServicio,
                'precio_hora_extra' => $precioHoraExtraServicio,
                'subtotal' => $tarifaSubtotal,
                'incluye' => $tarifaBase?->incluye ?? [],
            ],
            'zona' => $zona ? [
                'id' => $zona->id,
                'nombre' => $zona->nombre,
                'descripcion' => $zona->descripcion,
                'recargo' => (float) $zona->recargo,
                'a_consultar' => (bool) $zona->a_consultar,
            ] : null,
            'recargo_zona' => $recargoZona,
            'horas_extra_viaje' => [
                'horas' => $horasExtraViaje,
                'precio_hora' => $precioHoraExtraViaje,
                'subtotal' => $subtotalHorasExtraViaje,
            ],
            'extras' => $extrasList,
            'extras_subtotal' => $extrasSubtotal,
            'nocturnidad' => [
                'aplica' => $aplicaNocturnidad,
                'desde_hora' => $ajuste->nocturnidad_desde_hora,
                'importe' => $nocturnidadImporte,
            ],
            'a_consultar' => $aConsultar,
            'total' => $total,
        ];
    }
}
