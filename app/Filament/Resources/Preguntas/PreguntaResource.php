<?php

namespace App\Filament\Resources\Preguntas;

use App\Filament\Resources\Preguntas\Pages\CreatePregunta;
use App\Filament\Resources\Preguntas\Pages\EditPregunta;
use App\Filament\Resources\Preguntas\Pages\ListPreguntas;
use App\Filament\Resources\Preguntas\Schemas\PreguntaForm;
use App\Filament\Resources\Preguntas\Tables\PreguntasTable;
use App\Models\Pregunta;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class PreguntaResource extends Resource
{
    protected static ?string $model = Pregunta::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationLabel = 'Preguntas Frecuentes (FAQ)';

    protected static ?string $pluralModelLabel = 'Preguntas Frecuentes';

    protected static ?string $modelLabel = 'Pregunta Frecuente';

    protected static ?int $navigationSort = 9;

    public static function form(Schema $schema): Schema
    {
        return PreguntaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PreguntasTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPreguntas::route('/'),
            'create' => CreatePregunta::route('/create'),
            'edit' => EditPregunta::route('/{record}/edit'),
        ];
    }
}
