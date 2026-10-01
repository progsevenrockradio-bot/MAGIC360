<?php
namespace App\Filament\Resources\ClienteResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class FacturasRelationManager extends RelationManager
{
    protected static string $relationship = 'facturas';
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('numero')
            ->columns([
                Tables\Columns\TextColumn::make('numero'),
                Tables\Columns\TextColumn::make('total')->money('eur'),
                Tables\Columns\TextColumn::make('estado'),
            ]);
    }
}
