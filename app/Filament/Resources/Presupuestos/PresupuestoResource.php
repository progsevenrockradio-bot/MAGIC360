<?php

namespace App\Filament\Resources\Presupuestos;

use App\Filament\Resources\Presupuestos\Pages\CreatePresupuesto;
use App\Filament\Resources\Presupuestos\Pages\EditPresupuesto;
use App\Filament\Resources\Presupuestos\Pages\ListPresupuestos;
use App\Filament\Resources\Presupuestos\Schemas\PresupuestoForm;
use App\Filament\Resources\Presupuestos\Tables\PresupuestosTable;
use App\Models\Presupuesto;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PresupuestoResource extends Resource
{
    protected static ?string $model = Presupuesto::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-currency-euro';

    protected static ?string $navigationLabel = 'Presupuestos';

    protected static ?string $pluralModelLabel = 'Presupuestos';

    protected static ?string $modelLabel = 'Presupuesto';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('estado', 'enviado')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Schema $schema): Schema
    {
        return PresupuestoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PresupuestosTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPresupuestos::route('/'),
            'create' => CreatePresupuesto::route('/create'),
            'edit' => EditPresupuesto::route('/{record}/edit'),
        ];
    }
}
