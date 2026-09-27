<?php

namespace App\Filament\Resources\Preguntas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PreguntasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('orden')
                    ->label('Orden')
                    ->sortable(),
                TextColumn::make('pregunta')
                    ->label('Pregunta')
                    ->searchable()
                    ->limit(60),
                TextColumn::make('respuesta')
                    ->label('Respuesta')
                    ->limit(60),
                ToggleColumn::make('visible')
                    ->label('Visible'),
            ])
            ->defaultSort('orden', 'asc')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
