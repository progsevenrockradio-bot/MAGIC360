<?php
namespace App\Filament\Resources\Eventos\Pages;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Evento;
use App\Services\DisponibilidadService;

class AgendaCalendar extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        return Evento::query()
            ->where('fecha', '>=', $fetchInfo['start'])
            ->where('fecha', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Evento $evento) {
                $color = match($evento->estado) {
                    'reservado' => '#3b82f6',
                    'realizado' => '#10b981',
                    'cancelado' => '#9ca3af',
                    default => '#6b7280',
                };
                return [
                    'id' => $evento->id,
                    'title' => ($evento->cliente?->nombre ?? 'Sin cliente') . ' - ' . ($evento->maquina?->nombre ?? 'Sin maquina'),
                    'start' => $evento->fecha->format('Y-m-d') . 'T' . $evento->hora_inicio,
                    'end' => $evento->fecha->format('Y-m-d') . 'T' . $evento->hora_fin,
                    'color' => $color,
                ];
            })->toArray();
    }

    public function onEventDrop(array $event, array $oldEvent, array $relatedEvents, array $delta, ?array $oldResource, ?array $newResource): bool
    {
        $evento = Evento::find($event['id']);
        if ($evento) {
            $service = app(DisponibilidadService::class);
            $libre = $service->estaLibre(
                \Carbon\Carbon::parse($event['start']),
                \Carbon\Carbon::parse($event['start'])->format('H:i'),
                $evento->horas_servicio ?? 2,
                $evento->maquina_id
            );
            
            if (!$libre) {
                return false;
            }

            $evento->fecha = \Carbon\Carbon::parse($event['start']);
            $evento->hora_inicio = \Carbon\Carbon::parse($event['start'])->format('H:i');
            $evento->hora_fin = \Carbon\Carbon::parse($event['end'])->format('H:i');
            $evento->save();
            return true;
        }
        return false;
    }
}
