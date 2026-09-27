<?php

namespace App\Filament\Resources\Testimonios\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del cliente')
                    ->required(),
                TextInput::make('tipo_evento')
                    ->label('Tipo de evento / Ubicación')
                    ->placeholder('Ej: Boda en Alicante'),
                Textarea::make('texto')
                    ->label('Comentario / Opinión')
                    ->rows(4)
                    ->required(),
                Select::make('estrellas')
                    ->label('Valoración (Estrellas)')
                    ->options([
                        1 => '1 Estrella',
                        2 => '2 Estrellas',
                        3 => '3 Estrellas',
                        4 => '4 Estrellas',
                        5 => '5 Estrellas',
                    ])
                    ->default(5)
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
