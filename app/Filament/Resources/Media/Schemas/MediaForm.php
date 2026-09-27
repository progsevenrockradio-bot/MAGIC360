<?php

namespace App\Filament\Resources\Media\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MediaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('titulo')
                    ->label('Título / Descripción del archivo')
                    ->helperText('Usado para el atributo alt en las imágenes (SEO)'),
                Select::make('tipo')
                    ->label('Tipo de archivo')
                    ->options([
                        'video' => 'Vídeo (MP4 / YouTube / Vimeo)',
                        'imagen' => 'Imagen de galería (WebP / JPG / PNG)',
                    ])
                    ->default('imagen')
                    ->required(),
                FileUpload::make('archivo')
                    ->label('Subir archivo desde tu ordenador')
                    ->directory('galeria'),
                TextInput::make('url')
                    ->label('O enlace URL externo (MP4 / YouTube / Vimeo)'),
                FileUpload::make('miniatura')
                    ->label('Imagen de portada / Miniatura (opcional para vídeos)')
                    ->image()
                    ->directory('galeria/miniaturas'),
                TextInput::make('orden')
                    ->label('Orden')
                    ->numeric()
                    ->default(0),
                Toggle::make('visible')
                    ->label('Visible en la web')
                    ->default(true),
            ]);
    }
}
