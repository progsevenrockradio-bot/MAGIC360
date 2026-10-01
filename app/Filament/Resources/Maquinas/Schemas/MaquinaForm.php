<?php

namespace App\Filament\Resources\Maquinas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MaquinaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->required(),
                Toggle::make('activa')
                    ->required(),
                Textarea::make('notas')
                    ->columnSpanFull(),
            ]);
    }
}
