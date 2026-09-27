<?php

namespace App\Filament\Pages;

use App\Models\Ajuste;
use BackedEnum;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Ajustes extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected string $view = 'filament.pages.ajustes';

    protected static ?string $title = 'Ajustes Generales';

    protected static ?string $navigationLabel = 'Ajustes Generales';

    protected static ?int $navigationSort = 1;

    public ?array $data = [];

    public function mount(): void
    {
        $ajuste = Ajuste::firstOrCreate(['id' => 1]);
        $this->form->fill($ajuste->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Ajustes')
                    ->tabs([
                        Tabs\Tab::make('General y Contacto')
                            ->icon('heroicon-o-building-office')
                            ->schema([
                                Section::make('Identidad de Marca')
                                    ->schema([
                                        TextInput::make('nombre_marca')
                                            ->label('Nombre de la marca')
                                            ->required(),
                                        TextInput::make('eslogan')
                                            ->label('Eslogan / Subtítulo corto'),
                                        FileUpload::make('logo')
                                            ->label('Logo principal')
                                            ->image()
                                            ->directory('config'),
                                        FileUpload::make('favicon')
                                            ->label('Favicon')
                                            ->image()
                                            ->directory('config'),
                                    ])->columns(2),

                                Section::make('Datos de Contacto')
                                    ->schema([
                                        TextInput::make('telefono')
                                            ->label('Teléfono público')
                                            ->required(),
                                        TextInput::make('whatsapp')
                                            ->label('Número de WhatsApp (con prefijo sin +)')
                                            ->helperText('Ejemplo: 34600000000')
                                            ->required(),
                                        TextInput::make('email_contacto')
                                            ->label('Email de contacto (público)')
                                            ->email()
                                            ->required(),
                                        TextInput::make('email_avisos')
                                            ->label('Email para recibir avisos del formulario')
                                            ->email()
                                            ->required(),
                                        TextInput::make('horario')
                                            ->label('Horario de atención'),
                                    ])->columns(2),
                            ]),

                        Tabs\Tab::make('Portada y Textos')
                            ->icon('heroicon-o-home')
                            ->schema([
                                Section::make('Hero (Sección principal de la portada)')
                                    ->schema([
                                        TextInput::make('hero_titulo')
                                            ->label('Título principal (H1)')
                                            ->required(),
                                        Textarea::make('hero_subtitulo')
                                            ->label('Subtítulo del Hero')
                                            ->rows(3),
                                        FileUpload::make('hero_video')
                                            ->label('Archivo de vídeo (MP4 local)')
                                            ->directory('video'),
                                        TextInput::make('hero_video_url')
                                            ->label('O URL externa de vídeo (MP4 / YouTube)'),
                                        FileUpload::make('hero_imagen')
                                            ->label('Imagen de portada (Fallback si no hay vídeo)')
                                            ->image()
                                            ->directory('imagenes'),
                                    ])->columns(2),

                                Section::make('Textos Informativos')
                                    ->schema([
                                        Textarea::make('texto_que_es')
                                            ->label('Texto de la sección "¿Qué es?"')
                                            ->rows(3),
                                        Textarea::make('texto_como_funciona')
                                            ->label('Texto de la sección "Cómo funciona"')
                                            ->rows(3),
                                    ]),
                            ]),

                        Tabs\Tab::make('Precios y Cobertura')
                            ->icon('heroicon-o-currency-euro')
                            ->schema([
                                Section::make('Configuración de Tarifas y Zonas')
                                    ->schema([
                                        TextInput::make('tarifas_titulo')
                                            ->label('Título de la sección de precios'),
                                        Textarea::make('tarifas_nota')
                                            ->label('Nota a pie de precios / condiciones')
                                            ->rows(3),
                                        Toggle::make('precio_desde')
                                            ->label('Mostrar etiqueta "Desde" en precios'),
                                        TextInput::make('moneda')
                                            ->label('Símbolo de moneda')
                                            ->default('€'),
                                        TextInput::make('desplazamiento_incluido_km')
                                            ->label('Km de desplazamiento incluidos en Zona A')
                                            ->numeric()
                                            ->default(25),
                                        TextInput::make('zona_consulta_texto')
                                            ->label('Texto para zona "A consultar"')
                                            ->default('A consultar'),
                                    ])->columns(2),

                                Section::make('Recargo de Nocturnidad')
                                    ->schema([
                                        Toggle::make('nocturnidad_activa')
                                            ->label('Activar recargo de nocturnidad'),
                                        TextInput::make('nocturnidad_desde_hora')
                                            ->label('Hora a partir de la cual aplica nocturnidad')
                                            ->default('00:00'),
                                        TextInput::make('nocturnidad_importe')
                                            ->label('Importe del recargo (€)')
                                            ->numeric()
                                            ->default(50.00),
                                    ])->columns(3),
                            ]),

                        Tabs\Tab::make('Redes y Radio')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Section::make('Redes Sociales')
                                    ->schema([
                                        TextInput::make('instagram')->label('URL de Instagram'),
                                        TextInput::make('facebook')->label('URL de Facebook'),
                                        TextInput::make('tiktok')->label('URL de TikTok'),
                                        TextInput::make('youtube')->label('URL de YouTube'),
                                    ])->columns(2),

                                Section::make('Reproductor de Radio / Directo')
                                    ->schema([
                                        Toggle::make('radio_activa')
                                            ->label('Activar sección reproductor de radio'),
                                        TextInput::make('radio_nombre')
                                            ->label('Nombre del canal de radio'),
                                        TextInput::make('radio_url')
                                            ->label('URL del Stream de Audio'),
                                        TextInput::make('radio_horario')
                                            ->label('Horario de emisión'),
                                    ])->columns(2),
                            ]),

                        Tabs\Tab::make('SEO y Redes')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                Section::make('Meta etiquetas y Posicionamiento SEO')
                                    ->schema([
                                        TextInput::make('ciudad')
                                            ->label('Ciudad principal')
                                            ->required(),
                                        TextInput::make('zona_cobertura')
                                            ->label('Provincia / Zona de cobertura')
                                            ->required(),
                                        TextInput::make('seo_titulo')
                                            ->label('Título Meta / SEO (<title>)')
                                            ->required(),
                                        Textarea::make('seo_descripcion')
                                            ->label('Descripción Meta / SEO (Meta description)')
                                            ->rows(3)
                                            ->required(),
                                        Textarea::make('seo_palabras')
                                            ->label('Palabras clave (Keywords separadas por coma)')
                                            ->rows(2),
                                        FileUpload::make('seo_imagen')
                                            ->label('Imagen social para compartir (Open Graph 1200x630)')
                                            ->image()
                                            ->directory('seo'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Paleta de Colores')
                            ->icon('heroicon-o-swatch')
                            ->schema([
                                Section::make('Colores del Logo (Editables)')
                                    ->description('Personaliza la paleta de colores de la web. Se aplican automáticamente a fondos, degradados, botones y acentos.')
                                    ->schema([
                                        ColorPicker::make('color_negro')
                                            ->label('Fondo Principal (Negro)')
                                            ->default('#000000'),
                                        ColorPicker::make('color_negro_suave')
                                            ->label('Fondo Tarjetas / Secciones (Negro Suave)')
                                            ->default('#0A0B14'),
                                        ColorPicker::make('color_azul')
                                            ->label('Azul Eléctrico (Enlaces/Iconos)')
                                            ->default('#024EFF'),
                                        ColorPicker::make('color_azul_claro')
                                            ->label('Azul Claro (Halos/Líneas)')
                                            ->default('#8F94FF'),
                                        ColorPicker::make('color_dorado')
                                            ->label('Dorado (Titulares/Precios)')
                                            ->default('#FFD400'),
                                        ColorPicker::make('color_dorado_claro')
                                            ->label('Dorado Claro (Brillos)')
                                            ->default('#FFF14A'),
                                        ColorPicker::make('color_naranja')
                                            ->label('Naranja (Botones/CTA)')
                                            ->default('#FF9500'),
                                        ColorPicker::make('color_rojo')
                                            ->label('Rojo Acento (Cálido)')
                                            ->default('#FF3005'),
                                        ColorPicker::make('color_blanco')
                                            ->label('Texto Principal (Blanco)')
                                            ->default('#FFFFFF'),
                                        ColorPicker::make('color_gris')
                                            ->label('Texto Secundario (Gris)')
                                            ->default('#B9BCC8'),
                                    ])->columns(2),
                            ]),

                        Tabs\Tab::make('Legales y WhatsApp')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Section::make('Mensaje prediseñado WhatsApp')
                                    ->schema([
                                        Textarea::make('whatsapp_mensaje')
                                            ->label('Mensaje por defecto para WhatsApp')
                                            ->rows(2),
                                        Textarea::make('texto_pie')
                                            ->label('Texto del Copyright en el pie de página')
                                            ->rows(2),
                                    ]),

                                Section::make('Páginas Legales')
                                    ->schema([
                                        RichEditor::make('aviso_legal')
                                            ->label('Aviso Legal'),
                                        RichEditor::make('privacidad')
                                            ->label('Política de Privacidad'),
                                        RichEditor::make('cookies')
                                            ->label('Política de Cookies'),
                                    ]),
                            ]),
                    ])->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $ajuste = Ajuste::firstOrCreate(['id' => 1]);
        $ajuste->update($data);

        Notification::make()
            ->title('Ajustes guardados correctamente')
            ->success()
            ->send();
    }
}
