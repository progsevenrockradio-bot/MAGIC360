<?php

namespace App\Filament\Resources\Zonas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ZonaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre de la zona')
                    ->placeholder('Ej: Zona B')
                    ->required(),
                TextInput::make('descripcion')
                    ->label('Descripción / Rango de distancia')
                    ->placeholder('Ej: De 25 a 50 km del centro'),
                TextInput::make('recargo')
                    ->label('Recargo por desplazamiento (€)')
                    ->numeric()
                    ->prefix('€')
                    ->default(0),
                Toggle::make('a_consultar')
                    ->label('Marcar como "A consultar" (sin recargo fijo)'),
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
