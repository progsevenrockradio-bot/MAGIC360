<?php

namespace App\Filament\Resources\Zonas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ZonasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('orden')
                    ->label('Orden')
                    ->sortable(),
                TextColumn::make('nombre')
                    ->label('Zona')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('descripcion')
                    ->label('Rango de distancia'),
                TextColumn::make('recargo')
                    ->label('Recargo')
                    ->money('EUR')
                    ->sortable(),
                ToggleColumn::make('a_consultar')
                    ->label('A consultar'),
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
