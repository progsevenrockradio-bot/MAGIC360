<?php
$files = [
    'app/Filament/Resources/ClienteResource/RelationManagers/PresupuestosRelationManager.php' => '<?php
namespace App\Filament\Resources\ClienteResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PresupuestosRelationManager extends RelationManager
{
    protected static string $relationship = \'presupuestos\';
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute(\'numero\')
            ->columns([
                Tables\Columns\TextColumn::make(\'numero\'),
                Tables\Columns\TextColumn::make(\'fecha_evento\')->date(),
                Tables\Columns\TextColumn::make(\'total\')->money(\'eur\'),
            ]);
    }
}
',
    'app/Filament/Resources/ClienteResource/RelationManagers/EventosRelationManager.php' => '<?php
namespace App\Filament\Resources\ClienteResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EventosRelationManager extends RelationManager
{
    protected static string $relationship = \'eventos\';
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute(\'id\')
            ->columns([
                Tables\Columns\TextColumn::make(\'fecha\')->date(),
                Tables\Columns\TextColumn::make(\'hora_inicio\'),
                Tables\Columns\TextColumn::make(\'estado\')->badge(),
            ]);
    }
}
',
    'app/Filament/Resources/ClienteResource/RelationManagers/FacturasRelationManager.php' => '<?php
namespace App\Filament\Resources\ClienteResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class FacturasRelationManager extends RelationManager
{
    protected static string $relationship = \'facturas\';
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute(\'numero\')
            ->columns([
                Tables\Columns\TextColumn::make(\'numero\'),
                Tables\Columns\TextColumn::make(\'total\')->money(\'eur\'),
                Tables\Columns\TextColumn::make(\'estado\'),
            ]);
    }
}
',
    'app/Filament/Resources/MaquinaResource/RelationManagers/EventosRelationManager.php' => '<?php
namespace App\Filament\Resources\MaquinaResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EventosRelationManager extends RelationManager
{
    protected static string $relationship = \'eventos\';
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute(\'id\')
            ->columns([
                Tables\Columns\TextColumn::make(\'fecha\')->date(),
                Tables\Columns\TextColumn::make(\'cliente.nombre\'),
                Tables\Columns\TextColumn::make(\'estado\')->badge(),
            ]);
    }
}
',
    'app/Filament/Resources/UserResource/RelationManagers/EventosRelationManager.php' => '<?php
namespace App\Filament\Resources\UserResource\RelationManagers;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class EventosRelationManager extends RelationManager
{
    protected static string $relationship = \'eventosAsignados\';
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute(\'id\')
            ->columns([
                Tables\Columns\TextColumn::make(\'fecha\')->date(),
                Tables\Columns\TextColumn::make(\'cliente.nombre\'),
                Tables\Columns\TextColumn::make(\'estado\')->badge(),
            ]);
    }
}
',
    'app/Filament/Resources/Eventos/Pages/AgendaCalendar.php' => '<?php
namespace App\Filament\Resources\Eventos\Pages;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use App\Models\Evento;
use App\Services\DisponibilidadService;

class AgendaCalendar extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        return Evento::query()
            ->where(\'fecha\', \'>=\', $fetchInfo[\'start\'])
            ->where(\'fecha\', \'<=\', $fetchInfo[\'end\'])
            ->get()
            ->map(function (Evento $evento) {
                $color = match($evento->estado) {
                    \'reservado\' => \'#3b82f6\',
                    \'realizado\' => \'#10b981\',
                    \'cancelado\' => \'#9ca3af\',
                    default => \'#6b7280\',
                };
                return [
                    \'id\' => $evento->id,
                    \'title\' => ($evento->cliente?->nombre ?? \'Sin cliente\') . \' - \' . ($evento->maquina?->nombre ?? \'Sin maquina\'),
                    \'start\' => $evento->fecha->format(\'Y-m-d\') . \'T\' . $evento->hora_inicio,
                    \'end\' => $evento->fecha->format(\'Y-m-d\') . \'T\' . $evento->hora_fin,
                    \'color\' => $color,
                ];
            })->toArray();
    }

    public function onEventDrop(array $info): void
    {
        $evento = Evento::find($info[\'event\'][\'id\']);
        if ($evento) {
            $service = app(DisponibilidadService::class);
            $libre = $service->estaLibre(
                \Carbon\Carbon::parse($info[\'event\'][\'start\']),
                \Carbon\Carbon::parse($info[\'event\'][\'start\'])->format(\'H:i\'),
                $evento->horas_servicio ?? 2,
                $evento->maquina_id
            );
            
            if (!$libre) {
                return;
            }

            $evento->fecha = \Carbon\Carbon::parse($info[\'event\'][\'start\']);
            $evento->hora_inicio = \Carbon\Carbon::parse($info[\'event\'][\'start\'])->format(\'H:i\');
            $evento->hora_fin = \Carbon\Carbon::parse($info[\'event\'][\'end\'])->format(\'H:i\');
            $evento->save();
        }
    }
}
'
];

foreach ($files as $path => $content) {
    @mkdir(dirname($path), 0777, true);
    file_put_contents($path, $content);
}
echo "OK\n";
