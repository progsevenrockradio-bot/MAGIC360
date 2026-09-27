<?php

namespace App\Filament\Resources\Mensajes;

use App\Filament\Resources\Mensajes\Pages\CreateMensaje;
use App\Filament\Resources\Mensajes\Pages\EditMensaje;
use App\Filament\Resources\Mensajes\Pages\ListMensajes;
use App\Filament\Resources\Mensajes\Schemas\MensajeForm;
use App\Filament\Resources\Mensajes\Tables\MensajesTable;
use App\Models\Mensaje;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class MensajeResource extends Resource
{
    protected static ?string $model = Mensaje::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Mensajes de Contacto';

    protected static ?string $pluralModelLabel = 'Mensajes de Contacto';

    protected static ?string $modelLabel = 'Mensaje';

    protected static ?int $navigationSort = 10;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('atendido', false)->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        return MensajeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MensajesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMensajes::route('/'),
            'create' => CreateMensaje::route('/create'),
            'edit' => EditMensaje::route('/{record}/edit'),
        ];
    }
}
