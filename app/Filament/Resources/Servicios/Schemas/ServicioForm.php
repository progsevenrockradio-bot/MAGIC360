<?php

namespace App\Filament\Resources\Servicios\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServicioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titulo')
                    ->label('Título de la tarjeta')
                    ->required(),
                Textarea::make('descripcion')
                    ->label('Descripción corta')
                    ->rows(3)
                    ->required(),
                TextInput::make('icono')
                    ->label('Identificador de icono (SVG / Heroicon)')
                    ->placeholder('Ej: video-camera, paint-brush, qr-code'),
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
