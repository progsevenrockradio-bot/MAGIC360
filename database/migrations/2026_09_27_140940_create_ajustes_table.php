<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ajustes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_marca')->default('Magic360');
            $table->string('eslogan')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();

            $table->string('telefono')->default('+34 600 000 000');
            $table->string('whatsapp')->default('34600000000');
            $table->string('email_contacto')->default('info@magic360.es');
            $table->string('email_avisos')->default('avisos@magic360.es');

            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('youtube')->nullable();

            $table->string('ciudad')->default('Alicante');
            $table->string('zona_cobertura')->default('Alicante y la Costa Blanca');
            $table->string('horario')->default('Atención de Lunes a Domingo de 09:00 a 22:00');

            $table->string('hero_titulo')->nullable();
            $table->text('hero_subtitulo')->nullable();
            $table->string('hero_video')->nullable();
            $table->string('hero_video_url')->nullable();
            $table->string('hero_imagen')->nullable();

            $table->text('texto_que_es')->nullable();
            $table->text('texto_como_funciona')->nullable();

            $table->string('tarifas_titulo')->nullable();
            $table->text('tarifas_nota')->nullable();
            $table->boolean('precio_desde')->default(true);
            $table->string('moneda')->default('€');

            $table->boolean('nocturnidad_activa')->default(true);
            $table->string('nocturnidad_desde_hora')->default('00:00');
            $table->decimal('nocturnidad_importe', 8, 2)->default(50.00);

            $table->integer('desplazamiento_incluido_km')->default(25);
            $table->string('zona_consulta_texto')->default('A consultar');

            $table->boolean('radio_activa')->default(false);
            $table->string('radio_nombre')->nullable();
            $table->string('radio_url')->nullable();
            $table->string('radio_horario')->nullable();

            $table->string('seo_titulo')->nullable();
            $table->text('seo_descripcion')->nullable();
            $table->text('seo_palabras')->nullable();
            $table->string('seo_imagen')->nullable();

            // Dynamic Brand Color Palette
            $table->string('color_negro')->default('#000000');
            $table->string('color_negro_suave')->default('#0A0B14');
            $table->string('color_azul')->default('#024EFF');
            $table->string('color_azul_claro')->default('#8F94FF');
            $table->string('color_dorado')->default('#FFD400');
            $table->string('color_dorado_claro')->default('#FFF14A');
            $table->string('color_naranja')->default('#FF9500');
            $table->string('color_rojo')->default('#FF3005');
            $table->string('color_blanco')->default('#FFFFFF');
            $table->string('color_gris')->default('#B9BCC8');

            $table->longText('aviso_legal')->nullable();
            $table->longText('privacidad')->nullable();
            $table->longText('cookies')->nullable();

            $table->text('texto_pie')->nullable();
            $table->text('whatsapp_mensaje')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ajustes');
    }
};
