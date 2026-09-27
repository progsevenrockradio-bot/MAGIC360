<?php

namespace App\Filament\Resources\Media\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MediaTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('orden')
                    ->label('Orden')
                    ->sortable(),
                ImageColumn::make('miniatura_o_archivo')
                    ->label('Vista Previa')
                    ->state(fn ($record) => $record->miniatura ? asset('storage/'.$record->miniatura) : ($record->tipo === 'imagen' && $record->archivo ? asset('storage/'.$record->archivo) : ($record->url ? $record->url : null))),
                TextColumn::make('titulo')
                    ->label('Título / Alt text')
                    ->searchable(),
                TextColumn::make('tipo')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'video' => 'warning',
                        'imagen' => 'success',
                    }),
                ToggleColumn::make('visible')
                    ->label('Visible'),
            ])
            ->defaultSort('orden', 'asc')
            ->filters([
                SelectFilter::make('tipo')
                    ->options([
                        'video' => 'Vídeos',
                        'imagen' => 'Imágenes',
                    ]),
            ])
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
