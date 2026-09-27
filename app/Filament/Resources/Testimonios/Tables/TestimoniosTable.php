<?php

namespace App\Filament\Resources\Testimonios\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TestimoniosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('orden')
                    ->label('Orden')
                    ->sortable(),
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tipo_evento')
                    ->label('Evento / Ciudad'),
                TextColumn::make('estrellas')
                    ->label('Estrellas')
                    ->badge()
                    ->color('warning'),
                TextColumn::make('texto')
                    ->label('Opinión')
                    ->limit(50),
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
