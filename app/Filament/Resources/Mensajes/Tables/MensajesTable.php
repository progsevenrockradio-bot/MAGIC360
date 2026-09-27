<?php

namespace App\Filament\Resources\Mensajes\Tables;

use App\Models\Mensaje;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class MensajesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Fecha Recepción')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('telefono')
                    ->label('Teléfono')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('fecha_evento')
                    ->label('Fecha Evento')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('tipo_evento')
                    ->label('Evento'),
                TextColumn::make('horas')
                    ->label('Horas'),
                ToggleColumn::make('atendido')
                    ->label('Atendido'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('atendido')
                    ->label('Estado')
                    ->options([
                        '0' => 'Pendientes (Sin atender)',
                        '1' => 'Atendidos',
                    ]),
            ])
            ->recordActions([
                Action::make('llamar')
                    ->label('Llamar')
                    ->icon('heroicon-o-phone')
                    ->color('success')
                    ->url(fn (Mensaje $record) => 'tel:'.preg_replace('/[^0-9+]/', '', $record->telefono), shouldOpenInNewTab: true),
                Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('info')
                    ->url(function (Mensaje $record) {
                        $num = preg_replace('/[^0-9]/', '', $record->telefono);
                        if (! str_starts_with($num, '34') && strlen($num) === 9) {
                            $num = '34'.$num;
                        }
                        $msg = rawurlencode("Hola {$record->nombre}, te contacto de Magic360 respecto a tu consulta para la cabina 360 del día ".($record->fecha_evento ? $record->fecha_evento->format('d/m/Y') : ''));

                        return "https://wa.me/{$num}?text={$msg}";
                    }, shouldOpenInNewTab: true),
                EditAction::make()->label('Ver Detalle'),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('export_csv')
                        ->label('Exportar a CSV')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (Collection $records) {
                            $csvData = "ID;Nombre;Telefono;Email;Fecha Evento;Ciudad;Tipo Evento;Horas;Zona;Mensaje;Atendido;Fecha Creacion\n";
                            foreach ($records as $row) {
                                $csvData .= sprintf(
                                    '"%s";"%s";"%s";"%s";"%s";"%s";"%s";"%s";"%s";"%s";"%s";"%s"'."\n",
                                    $row->id,
                                    str_replace('"', '""', $row->nombre),
                                    str_replace('"', '""', $row->telefono),
                                    str_replace('"', '""', $row->email),
                                    $row->fecha_evento ? $row->fecha_evento->format('Y-m-d') : '',
                                    str_replace('"', '""', $row->ciudad ?? ''),
                                    str_replace('"', '""', $row->tipo_evento ?? ''),
                                    str_replace('"', '""', $row->horas ?? ''),
                                    str_replace('"', '""', $row->zona ?? ''),
                                    str_replace('"', '""', $row->mensaje ?? ''),
                                    $row->atendido ? 'SI' : 'NO',
                                    $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : ''
                                );
                            }

                            return response()->streamDownload(function () use ($csvData) {
                                echo "\xEF\xBB\xBF"; // UTF-8 BOM
                                echo $csvData;
                            }, 'solicitudes_magic360_'.date('Y-m-d').'.csv', [
                                'Content-Type' => 'text/csv; charset=UTF-8',
                            ]);
                        }),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
