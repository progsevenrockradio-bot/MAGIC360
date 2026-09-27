<?php

namespace App\Filament\Resources\Tarifas\Schemas;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TarifaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre de la tarifa')
                    ->placeholder('Ej: 2 horas')
                    ->required(),
                TextInput::make('horas')
                    ->label('Número de horas (dejar vacío si no aplica)')
                    ->numeric(),
                TextInput::make('precio')
                    ->label('Precio (€)')
                    ->numeric()
                    ->prefix('€'),
                Toggle::make('precio_desde')
                    ->label('Mostrar "Desde"'),
                TagsInput::make('incluye')
                    ->label('¿Qué incluye esta tarifa?')
                    ->placeholder('Añadir elemento y pulsar Enter')
                    ->columnSpanFull(),
                Toggle::make('destacada')
                    ->label('Marcar como "La más pedida" (Destacada)'),
                TextInput::make('orden')
                    ->label('Orden de aparición')
                    ->numeric()
                    ->default(0),
                Toggle::make('visible')
                    ->label('Visible en la web')
                    ->default(true),
            ]);
    }
}
