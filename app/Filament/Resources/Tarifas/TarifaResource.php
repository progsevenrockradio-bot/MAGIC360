<?php

namespace App\Filament\Resources\Tarifas;

use App\Filament\Resources\Tarifas\Pages\CreateTarifa;
use App\Filament\Resources\Tarifas\Pages\EditTarifa;
use App\Filament\Resources\Tarifas\Pages\ListTarifas;
use App\Filament\Resources\Tarifas\Schemas\TarifaForm;
use App\Filament\Resources\Tarifas\Tables\TarifasTable;
use App\Models\Tarifa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TarifaResource extends Resource
{
    protected static ?string $model = Tarifa::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-euro';

    protected static ?string $navigationLabel = 'Tarifas (Precios)';

    protected static ?string $pluralModelLabel = 'Tarifas';

    protected static ?string $modelLabel = 'Tarifa';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return TarifaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TarifasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTarifas::route('/'),
            'create' => CreateTarifa::route('/create'),
            'edit' => EditTarifa::route('/{record}/edit'),
        ];
    }
}
