<?php
namespace App\Filament\Resources\ClienteResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PresupuestosRelationManager extends RelationManager
{
    protected static string $relationship = 'presupuestos';
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('numero')
            ->columns([
                Tables\Columns\TextColumn::make('numero'),
                Tables\Columns\TextColumn::make('fecha_evento')->date(),
                Tables\Columns\TextColumn::make('total')->money('eur'),
            ]);
    }
}
