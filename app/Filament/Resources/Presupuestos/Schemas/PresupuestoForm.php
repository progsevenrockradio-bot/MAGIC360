<?php

namespace App\Filament\Resources\Presupuestos\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PresupuestoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Datos del Presupuesto')
                    ->schema([
                        TextInput::make('numero')
                            ->label('Número de Presupuesto')
                            ->disabled()
                            ->dehydrated(false),
                        DatePicker::make('fecha')
                            ->label('Fecha de emisión')
                            ->required(),
                        Select::make('estado')
                            ->label('Estado')
                            ->options([
                                'borrador' => 'Borrador',
                                'enviado' => 'Enviado al cliente',
                                'aceptado' => 'Aceptado (Confirmado)',
                                'rechazado' => 'Rechazado / Cancelado',
                            ])
                            ->required()
                            ->default('enviado'),
                        TextInput::make('total')
                            ->label('Total (€ con IVA)')
                            ->numeric()
                            ->prefix('€')
                            ->required(),
                    ])->columns(4),

                Section::make('Datos del Cliente y Evento')
                    ->schema([
                        TextInput::make('cliente_nombre')
                            ->label('Nombre del cliente')
                            ->required(),
                        TextInput::make('cliente_telefono')
                            ->label('Teléfono')
                            ->required(),
                        TextInput::make('cliente_email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        DatePicker::make('fecha_evento')
                            ->label('Fecha del evento'),
                        TextInput::make('ciudad')
                            ->label('Ciudad / Población'),
                        TextInput::make('tipo_evento')
                            ->label('Tipo de evento'),
                        TextInput::make('horas')
                            ->label('Horas de servicio contratadas')
                            ->numeric(),
                        TextInput::make('horas_extra_viaje')
                            ->label('Horas extra viaje / espera')
                            ->numeric()
                            ->default(0),
                    ])->columns(4),

                Section::make('Notas y Observaciones')
                    ->schema([
                        Textarea::make('notas')
                            ->label('Notas internas / Comentarios del cliente')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
