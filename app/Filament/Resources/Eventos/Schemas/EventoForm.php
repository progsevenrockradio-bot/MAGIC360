<?php

namespace App\Filament\Resources\Eventos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class EventoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Select::make('cliente_id')
                ->relationship('cliente', 'nombre')
                ->searchable()
                ->required()
                ->createOptionForm([
                    TextInput::make('nombre')->required(),
                    TextInput::make('email')->email(),
                    TextInput::make('telefono'),
                ]),
            Select::make('maquina_id')
                ->relationship('maquina', 'nombre')
                ->required(),
            DatePicker::make('fecha')->required(),
            TimePicker::make('hora_inicio')->required(),
            TimePicker::make('hora_fin')->required(),
            TextInput::make('poblacion'),
            TextInput::make('direccion'),
            TextInput::make('importe_total')->numeric()->prefix('€'),
            Select::make('estado')
                ->options([
                    'reservado' => 'Reservado',
                    'realizado' => 'Realizado',
                    'cancelado' => 'Cancelado'
                ])
                ->default('reservado')
                ->required(),
            Textarea::make('notas')->columnSpanFull(),
        ]);
    }
}
