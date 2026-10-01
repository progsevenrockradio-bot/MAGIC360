<?php

namespace App\Filament\Resources\Presupuestos\Pages;

use App\Filament\Resources\Presupuestos\PresupuestoResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\URL;

class EditPresupuesto extends EditRecord
{
    protected static string $resource = PresupuestoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('descargar_pdf')
                ->label('Descargar PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('warning')
                ->url(fn () => URL::signedRoute('presupuesto.pdf', ['presupuesto' => $this->record->id]), shouldOpenInNewTab: true),
            DeleteAction::make(),
        ];
    }
}
