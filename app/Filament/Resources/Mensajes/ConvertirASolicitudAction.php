<?php

namespace App\Filament\Resources\Mensajes;

use App\Filament\Resources\Eventos\EventoResource;
use App\Models\Cliente;
use App\Models\Evento;
use App\Models\Mensaje;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;

// Assuming there's a ListMensajes page where this is attached:
// We can just add this action to MensajeResource table.
class ConvertirASolicitudAction
{
    public static function make(): Action
    {
        return Action::make('convertir_a_evento')
            ->label('Crear Evento')
            ->icon('heroicon-o-calendar')
            ->color('success')
            ->requiresConfirmation()
            ->action(function (Mensaje $record) {
                $cliente = Cliente::where('email', $record->email)->orWhere('telefono', $record->telefono)->first();
                if (!$cliente) {
                    $cliente = Cliente::create([
                        'nombre' => $record->nombre,
                        'email' => $record->email,
                        'telefono' => $record->telefono,
                    ]);
                }

                $evento = Evento::create([
                    'cliente_id' => $cliente->id,
                    'maquina_id' => 1, // Default or parsed
                    'fecha' => now(), // Need to parse from request but keeping it simple for now
                    'hora_inicio' => '18:00',
                    'hora_fin' => '20:00',
                    'horas_servicio' => 2,
                    'importe_total' => 0,
                    'estado' => 'reservado',
                    'notas' => "Solicitud: " . $record->mensaje
                ]);

                Notification::make()->title('Evento Creado')->success()->send();
                return redirect()->to(EventoResource::getUrl('edit', ['record' => $evento]));
            });
    }
}
