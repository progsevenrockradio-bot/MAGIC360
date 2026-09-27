<?php

namespace App\Filament\Resources\Pasos;

use App\Filament\Resources\Pasos\Pages\CreatePaso;
use App\Filament\Resources\Pasos\Pages\EditPaso;
use App\Filament\Resources\Pasos\Pages\ListPasos;
use App\Filament\Resources\Pasos\Schemas\PasoForm;
use App\Filament\Resources\Pasos\Tables\PasosTable;
use App\Models\Paso;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PasoResource extends Resource
{
    protected static ?string $model = Paso::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-list-bullet';

    protected static ?string $navigationLabel = 'Pasos (Cómo funciona)';

    protected static ?string $pluralModelLabel = 'Pasos';

    protected static ?string $modelLabel = 'Paso';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return PasoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PasosTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPasos::route('/'),
            'create' => CreatePaso::route('/create'),
            'edit' => EditPaso::route('/{record}/edit'),
        ];
    }
}
