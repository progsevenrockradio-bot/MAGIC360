<?php

namespace App\Services;

use App\Models\Evento;
use App\Models\Maquina;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DisponibilidadService
{
    /**
     * Comprueba si una fecha y rango de horas está libre.
     * Considera el margen de montaje de los ajustes.
     */
    public function estaLibre(Carbon $fecha, string $horaInicio, int $horas, ?int $maquinaId = null, ?int $ignorarEventoId = null): bool
    {
        $margen = DB::table('ajustes')->value('margen_montaje_horas') ?? 1;

        $inicioSolicitado = Carbon::parse($fecha->format('Y-m-d') . ' ' . $horaInicio)->subHours($margen);
        $finSolicitado = Carbon::parse($fecha->format('Y-m-d') . ' ' . $horaInicio)->addHours($horas)->addHours($margen);

        $query = Evento::where('estado', '!=', 'cancelado')
            ->whereDate('fecha', $fecha->format('Y-m-d'));

        if ($maquinaId) {
            $query->where('maquina_id', $maquinaId);
        }

        if ($ignorarEventoId) {
            $query->where('id', '!=', $ignorarEventoId);
        }

        $eventosDelDia = $query->get();

        foreach ($eventosDelDia as $evento) {
            $inicioEvento = Carbon::parse($evento->fecha->format('Y-m-d') . ' ' . $evento->hora_inicio)->subHours($margen);
            $finEvento = Carbon::parse($evento->fecha->format('Y-m-d') . ' ' . $evento->hora_fin)->addHours($margen);

            // Verificar solape
            if ($inicioSolicitado < $finEvento && $finSolicitado > $inicioEvento) {
                return false;
            }
        }

        return true;
    }

    /**
     * Devuelve fechas alternativas cercanas si está ocupada.
     */
    public function alternativas(Carbon $fecha, int $horas, ?int $maquinaId = null, int $cuantas = 3): array
    {
        $alternativas = [];
        $diasBuscados = 1;
        $maxDias = 30; // Evitar bucle infinito

        while (count($alternativas) < $cuantas && $diasBuscados <= $maxDias) {
            // Hacia adelante
            $fechaAdelante = $fecha->copy()->addDays($diasBuscados);
            if ($this->estaLibre($fechaAdelante, "12:00", $horas, $maquinaId)) {
                $alternativas[] = $fechaAdelante->format('Y-m-d');
            }

            if (count($alternativas) >= $cuantas) break;

            // Hacia atrás (si no es en el pasado)
            $fechaAtras = $fecha->copy()->subDays($diasBuscados);
            if ($fechaAtras->isFuture() || $fechaAtras->isToday()) {
                if ($this->estaLibre($fechaAtras, "12:00", $horas, $maquinaId)) {
                    $alternativas[] = $fechaAtras->format('Y-m-d');
                }
            }
            
            $diasBuscados++;
        }

        return array_unique($alternativas);
    }
}
