<?php

namespace App\Filament\Resources\Eventos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class EventoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('cliente_id')
                    ->required()
                    ->numeric(),
                TextInput::make('maquina_id')
                    ->required()
                    ->numeric(),
                TextInput::make('presupuesto_id')
                    ->numeric(),
                DatePicker::make('fecha')
                    ->required(),
                TimePicker::make('hora_inicio')
                    ->required(),
                TimePicker::make('hora_fin')
                    ->required(),
                TextInput::make('poblacion'),
                TextInput::make('direccion'),
                TextInput::make('zona_id')
                    ->numeric(),
                TextInput::make('horas_servicio')
                    ->required()
                    ->numeric(),
                TextInput::make('horas_extra_viaje')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('importe_total')
                    ->required()
                    ->numeric(),
                TextInput::make('senal_cobrada')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('estado')
                    ->required()
                    ->default('reservado'),
                Textarea::make('notas')
                    ->columnSpanFull(),
            ]);
    }
}
