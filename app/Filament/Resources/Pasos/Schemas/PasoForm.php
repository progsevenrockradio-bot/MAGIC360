<?php

namespace App\Filament\Resources\Pasos\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PasoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('numero')
                    ->label('Número del paso (1, 2, 3...)')
                    ->numeric()
                    ->required(),
                TextInput::make('titulo')
                    ->label('Título del paso')
                    ->required(),
                Textarea::make('descripcion')
                    ->label('Explicación detallada')
                    ->rows(3)
                    ->required(),
                TextInput::make('icono')
                    ->label('Icono'),
                TextInput::make('orden')
                    ->label('Orden')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
