<?php

namespace App\Filament\Resources\Preguntas\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PreguntaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('pregunta')
                    ->label('Pregunta frecuente')
                    ->rows(2)
                    ->required(),
                Textarea::make('respuesta')
                    ->label('Respuesta detallada')
                    ->rows(4)
                    ->required(),
                TextInput::make('orden')
                    ->label('Orden')
                    ->numeric()
                    ->default(0),
                Toggle::make('visible')
                    ->label('Visible')
                    ->default(true),
            ]);
    }
}
