<?php
$files = [
    'app/Filament/Resources/FacturaResource.php' => '<?php
namespace App\Filament\Resources;
use App\Filament\Resources\FacturaResource\Pages;
use App\Models\Factura;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Services\FacturacionService;
use Filament\Notifications\Notification;

class FacturaResource extends Resource
{
    protected static ?string $model = Factura::class;
    protected static ?string $navigationIcon = \'heroicon-o-document-currency-euro\';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make(\'cliente_id\')
                    ->relationship(\'cliente\', \'nombre\')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make(\'evento_id\')
                    ->relationship(\'evento\', \'fecha\')
                    ->nullable(),
                Forms\Components\DatePicker::make(\'fecha\')
                    ->label(\'Fecha Emisión\')
                    ->default(now()),
                Forms\Components\DatePicker::make(\'fecha_vencimiento\')
                    ->default(now()->addDays(30)),
                
                Forms\Components\Repeater::make(\'lineas\')
                    ->relationship()
                    ->schema([
                        Forms\Components\TextInput::make(\'concepto\')->required(),
                        Forms\Components\TextInput::make(\'cantidad\')->numeric()->default(1)->required(),
                        Forms\Components\TextInput::make(\'precio_unitario\')->numeric()->default(0)->required(),
                        Forms\Components\TextInput::make(\'descuento\')->numeric()->default(0),
                        Forms\Components\TextInput::make(\'subtotal\')->numeric()->disabled()->dehydrated(false)
                    ])->columnSpanFull(),

                Forms\Components\Section::make(\'Totales\')
                    ->schema([
                        Forms\Components\TextInput::make(\'base\')->numeric()->disabled(),
                        Forms\Components\TextInput::make(\'iva_porcentaje\')->numeric()->default(21)->disabled(),
                        Forms\Components\TextInput::make(\'iva_importe\')->numeric()->disabled(),
                        Forms\Components\TextInput::make(\'irpf_porcentaje\')->numeric()->disabled(),
                        Forms\Components\TextInput::make(\'irpf_importe\')->numeric()->disabled(),
                        Forms\Components\TextInput::make(\'total\')->numeric()->disabled(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(\'numero\')->searchable(),
                Tables\Columns\TextColumn::make(\'cliente.nombre\')->searchable(),
                Tables\Columns\TextColumn::make(\'fecha\')->date(),
                Tables\Columns\TextColumn::make(\'total\')
                    ->money(\'eur\')
                    ->sortable(),
                Tables\Columns\TextColumn::make(\'estado\')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        \'borrador\' => \'gray\',
                        \'emitida\' => \'warning\',
                        \'vencida\' => \'danger\',
                        \'pagada\' => \'success\',
                        default => \'gray\',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make(\'estado\')
                    ->options([
                        \'borrador\' => \'Borrador\',
                        \'emitida\' => \'Emitida\',
                        \'vencida\' => \'Vencida\',
                        \'pagada\' => \'Pagada\',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make(\'emitir\')
                    ->label(\'Emitir y Bloquear\')
                    ->requiresConfirmation()
                    ->color(\'warning\')
                    ->icon(\'heroicon-o-lock-closed\')
                    ->visible(fn (Factura $record) => $record->estado === \'borrador\')
                    ->action(function (Factura $record) {
                        try {
                            app(FacturacionService::class)->emitir($record);
                            Notification::make()->success()->title(\'Factura Emitida\')->send();
                        } catch (\Exception $e) {
                            Notification::make()->danger()->title(\'Error\')->body($e->getMessage())->send();
                        }
                    }),
                Tables\Actions\Action::make(\'marcar_pagada\')
                    ->label(\'Marcar Pagada\')
                    ->color(\'success\')
                    ->icon(\'heroicon-o-check-circle\')
                    ->visible(fn (Factura $record) => in_array($record->estado, [\'emitida\', \'vencida\']))
                    ->action(function (Factura $record) {
                        $record->update([\'estado\' => \'pagada\', \'fecha_pago\' => now()]);
                        Notification::make()->success()->title(\'Factura Pagada\')->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            \'index\' => Pages\ListFacturas::route(\'/\'),
            \'create\' => Pages\CreateFactura::route(\'/create\'),
            \'view\' => Pages\ViewFactura::route(\'/{record}\'),
            \'edit\' => Pages\EditFactura::route(\'/{record}/edit\'),
        ];
    }
}
',
    'app/Filament/Resources/FacturaResource/Pages/ListFacturas.php' => '<?php
namespace App\Filament\Resources\FacturaResource\Pages;
use App\Filament\Resources\FacturaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
class ListFacturas extends ListRecords {
    protected static string $resource = FacturaResource::class;
    protected function getHeaderActions(): array { return [ Actions\CreateAction::make() ]; }
}
',
    'app/Filament/Resources/FacturaResource/Pages/CreateFactura.php' => '<?php
namespace App\Filament\Resources\FacturaResource\Pages;
use App\Filament\Resources\FacturaResource;
use Filament\Resources\Pages\CreateRecord;
class CreateFactura extends CreateRecord {
    protected static string $resource = FacturaResource::class;
}
',
    'app/Filament/Resources/FacturaResource/Pages/EditFactura.php' => '<?php
namespace App\Filament\Resources\FacturaResource\Pages;
use App\Filament\Resources\FacturaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditFactura extends EditRecord {
    protected static string $resource = FacturaResource::class;
    protected function getHeaderActions(): array { return [ Actions\ViewAction::make() ]; }
}
',
    'app/Filament/Resources/FacturaResource/Pages/ViewFactura.php' => '<?php
namespace App\Filament\Resources\FacturaResource\Pages;
use App\Filament\Resources\FacturaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
class ViewFactura extends ViewRecord {
    protected static string $resource = FacturaResource::class;
    protected function getHeaderActions(): array { return [ Actions\EditAction::make() ]; }
}
'
];

foreach ($files as $path => $content) {
    @mkdir(dirname($path), 0777, true);
    file_put_contents($path, $content);
}
echo "OK\n";
