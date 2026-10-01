<?php

namespace App\Filament\Resources\Facturas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FacturaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('numero')
                    ->required(),
                TextInput::make('cliente_id')
                    ->required()
                    ->numeric(),
                TextInput::make('evento_id')
                    ->numeric(),
                DatePicker::make('fecha_emision')
                    ->required(),
                TextInput::make('base')
                    ->required()
                    ->numeric(),
                TextInput::make('iva_porcentaje')
                    ->required()
                    ->numeric()
                    ->default(21),
                TextInput::make('iva_importe')
                    ->required()
                    ->numeric(),
                TextInput::make('irpf_porcentaje')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('irpf_importe')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total')
                    ->required()
                    ->numeric(),
                TextInput::make('estado')
                    ->required()
                    ->default('emitida'),
                Textarea::make('notas')
                    ->columnSpanFull(),
                DateTimePicker::make('pdf_generado_at'),
            ]);
    }
}
