<?php

namespace App\Filament\Resources\Mensajes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MensajeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del cliente')
                    ->readOnly(),
                TextInput::make('telefono')
                    ->label('Teléfono')
                    ->readOnly(),
                TextInput::make('email')
                    ->label('Email')
                    ->readOnly(),
                DatePicker::make('fecha_evento')
                    ->label('Fecha del evento')
                    ->readOnly(),
                TextInput::make('ciudad')
                    ->label('Ciudad / Población')
                    ->readOnly(),
                TextInput::make('tipo_evento')
                    ->label('Tipo de evento')
                    ->readOnly(),
                TextInput::make('horas')
                    ->label('Horas solicitadas')
                    ->readOnly(),
                TextInput::make('zona')
                    ->label('Zona seleccionada')
                    ->readOnly(),
                Textarea::make('mensaje')
                    ->label('Mensaje / Comentario')
                    ->rows(4)
                    ->readOnly()
                    ->columnSpanFull(),
                TextInput::make('ip')
                    ->label('Dirección IP')
                    ->readOnly(),
                TextInput::make('user_agent')
                    ->label('Navegador / User Agent')
                    ->readOnly()
                    ->columnSpanFull(),
                Toggle::make('atendido')
                    ->label('Marcar como atendido'),
            ]);
    }
}
