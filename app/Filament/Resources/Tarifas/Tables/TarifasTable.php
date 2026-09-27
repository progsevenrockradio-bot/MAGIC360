<?php

namespace App\Filament\Resources\Tarifas\Tables;

use App\Models\Tarifa;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TarifasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('orden')
                    ->label('Orden')
                    ->sortable(),
                TextColumn::make('nombre')
                    ->label('Tarifa')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('horas')
                    ->label('Horas')
                    ->sortable(),
                TextColumn::make('precio')
                    ->label('Precio')
                    ->money('EUR')
                    ->sortable(),
                ToggleColumn::make('destacada')
                    ->label('La más pedida'),
                ToggleColumn::make('visible')
                    ->label('Visible'),
            ])
            ->defaultSort('orden', 'asc')
            ->recordActions([
                EditAction::make(),
                Action::make('duplicar')
                    ->label('Duplicar')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (Tarifa $record) {
                        $nueva = $record->replicate();
                        $nueva->nombre = $record->nombre.' (Copia)';
                        $nueva->save();

                        Notification::make()
                            ->title('Tarifa duplicada correctamente')
                            ->success()
                            ->send();
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
