<?php

namespace App\Filament\Resources\Testimonios;

use App\Filament\Resources\Testimonios\Pages\CreateTestimonio;
use App\Filament\Resources\Testimonios\Pages\EditTestimonio;
use App\Filament\Resources\Testimonios\Pages\ListTestimonios;
use App\Filament\Resources\Testimonios\Schemas\TestimonioForm;
use App\Filament\Resources\Testimonios\Tables\TestimoniosTable;
use App\Models\Testimonio;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class TestimonioResource extends Resource
{
    protected static ?string $model = Testimonio::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationLabel = 'Opiniones (Testimonios)';

    protected static ?string $pluralModelLabel = 'Opiniones';

    protected static ?string $modelLabel = 'Opinión';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return TestimonioForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TestimoniosTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTestimonios::route('/'),
            'create' => CreateTestimonio::route('/create'),
            'edit' => EditTestimonio::route('/{record}/edit'),
        ];
    }
}
