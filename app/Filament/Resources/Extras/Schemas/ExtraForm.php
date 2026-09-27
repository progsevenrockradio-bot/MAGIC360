<?php

namespace App\Filament\Resources\Extras\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExtraForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del extra')
                    ->required(),
                TextInput::make('precio')
                    ->label('Precio (€)')
                    ->numeric()
                    ->prefix('€'),
                Textarea::make('descripcion')
                    ->label('Descripción corta')
                    ->rows(3),
                TextInput::make('orden')
                    ->label('Orden')
                    ->numeric()
                    ->default(0),
                Toggle::make('visible')
                    ->label('Visible en la web')
                    ->default(true),
            ]);
    }
}
