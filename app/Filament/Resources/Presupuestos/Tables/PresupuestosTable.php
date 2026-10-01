<?php

namespace App\Filament\Resources\Presupuestos\Tables;

use App\Models\Presupuesto;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\URL;

class PresupuestosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('numero')
                    ->label('Nº Presupuesto')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                TextColumn::make('fecha')
                    ->label('Fecha')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('cliente_nombre')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Presupuesto $record) => $record->cliente_telefono),
                TextColumn::make('tipo_evento')
                    ->label('Evento')
                    ->description(fn (Presupuesto $record) => $record->ciudad ?? '-'),
                TextColumn::make('horas')
                    ->label('Horas')
                    ->formatStateUsing(fn ($state) => $state ? "{$state} h" : '-'),
                TextColumn::make('total')
                    ->label('Total')
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 2, ',', '.').' €')
                    ->weight('bold')
                    ->color('warning')
                    ->sortable(),
                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'borrador' => 'gray',
                        'enviado' => 'info',
                        'aceptado' => 'success',
                        'rechazado' => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('estado')
                    ->label('Filtrar por estado')
                    ->options([
                        'borrador' => 'Borrador',
                        'enviado' => 'Enviado',
                        'aceptado' => 'Aceptado',
                        'rechazado' => 'Rechazado',
                    ]),
            ])
            ->recordActions([
                Action::make('descargar_pdf')
                    ->label('Descargar PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('warning')
                    ->url(fn (Presupuesto $record) => URL::signedRoute('presupuesto.pdf', ['presupuesto' => $record->id]), shouldOpenInNewTab: true),
                Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->url(function (Presupuesto $record) {
                        $num = preg_replace('/[^0-9]/', '', $record->cliente_telefono);
                        if (! str_starts_with($num, '34') && strlen($num) === 9) {
                            $num = '34'.$num;
                        }
                        $pdfUrl = URL::signedRoute('presupuesto.pdf', ['presupuesto' => $record->id]);
                        $msg = rawurlencode("Hola {$record->cliente_nombre}, te escribo de Magic360. Te adjunto tu presupuesto {$record->numero} para la cabina 360: {$pdfUrl}");

                        return "https://wa.me/{$num}?text={$msg}";
                    }, shouldOpenInNewTab: true),
                EditAction::make()->label('Ver / Editar'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
