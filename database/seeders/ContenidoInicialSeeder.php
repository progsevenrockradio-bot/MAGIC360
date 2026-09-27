<?php

namespace Database\Seeders;

use App\Models\Ajuste;
use App\Models\Extra;
use App\Models\Media;
use App\Models\Paso;
use App\Models\Pregunta;
use App\Models\Servicio;
use App\Models\Tarifa;
use App\Models\Testimonio;
use App\Models\Zona;
use Illuminate\Database\Seeder;

class ContenidoInicialSeeder extends Seeder
{
    public function run(): void
    {
        Ajuste::updateOrCreate(
            ['id' => 1],
            [
                'nombre_marca' => 'Magic360',
                'eslogan' => 'Alquiler de cabina 360º para bodas y eventos en Alicante',
                'telefono' => '+34 600 000 000',
                'whatsapp' => '34600000000',
                'email_contacto' => 'info@magic360.es',
                'email_avisos' => 'avisos@magic360.es',
                'instagram' => 'https://instagram.com/magic360_es',
                'facebook' => 'https://facebook.com/magic360es',
                'tiktok' => 'https://tiktok.com/@magic360_es',
                'youtube' => 'https://youtube.com/@magic360_es',
                'ciudad' => 'Alicante',
                'zona_cobertura' => 'Alicante y la Costa Blanca',
                'horario' => 'Atención de Lunes a Domingo de 09:00 a 22:00',
                'hero_titulo' => 'Tu evento, en 360º',
                'hero_subtitulo' => 'Alquiler de cabina 360 en Alicante para bodas, cumpleaños y empresas. Vídeo con cámara lenta, plantilla con el nombre de tu evento y descarga al móvil al momento.',
                'hero_video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'texto_que_es' => 'La experiencia audiovisual interactiva definitiva para tus invitados. Graba vídeos en 360º con efectos profesionales, música y marco personalizado.',
                'texto_como_funciona' => 'Sin complicaciones: nos desplazamos a tu zona de Alicante, montamos el espacio y nuestro personal atiende a tus invitados durante toda la celebración.',
                'tarifas_titulo' => 'Precios de alquiler de cabina 360',
                'tarifas_nota' => 'Precios con IVA incluido para eventos en Alicante y su provincia. Fuera de esa zona se suma el desplazamiento según distancia (Zona B: +30 € · Zona C: consultar). Los eventos que terminan a partir de las 00:00 llevan un recargo de nocturnidad de 50 €.',
                'precio_desde' => true,
                'moneda' => '€',
                'nocturnidad_activa' => true,
                'nocturnidad_desde_hora' => '00:00',
                'nocturnidad_importe' => 50.00,
                'desplazamiento_incluido_km' => 25,
                'zona_consulta_texto' => 'A consultar',
                'radio_activa' => false,
                'radio_nombre' => 'Radio Directo Magic360',
                'radio_url' => 'https://stream.zeno.fm/f3wvbb75ebduv',
                'radio_horario' => '24 horas Non-Stop',
                'seo_titulo' => 'Alquiler de Cabina 360 en Alicante | Desde 140 € · Magic360',
                'seo_descripcion' => 'Alquila tu cabina 360 para bodas, cumpleaños y empresas en Alicante. Vídeo 360º con plantilla personalizada, descarga al móvil al momento y montaje incluido. Pide precio hoy.',
                'seo_palabras' => 'alquiler cabina 360 Alicante, alquiler videomaton 360 Alicante, alquiler fotomaton 360 Alicante, cabina 360 bodas Alicante, plataforma 360 Alicante, cabina 360 para empresas Alicante, cabina 360 San Vicente del Raspeig, cabina 360 El Campello, cabina 360 Elche, cabina 360 Benidorm, cabina 360 Torrevieja, cabina 360 Costa Blanca',

                // Dynamic Colors
                'color_negro' => '#000000',
                'color_negro_suave' => '#0A0B14',
                'color_azul' => '#024EFF',
                'color_azul_claro' => '#8F94FF',
                'color_dorado' => '#FFD400',
                'color_dorado_claro' => '#FFF14A',
                'color_naranja' => '#FF9500',
                'color_rojo' => '#FF3005',
                'color_blanco' => '#FFFFFF',
                'color_gris' => '#B9BCC8',

                'aviso_legal' => '<h1>Aviso Legal</h1><p>En cumplimiento con el artículo 10 de la Ley 34/2002, de 11 de julio, de Servicios de la Sociedad de la Información y Comercio Electrónico (LSSI-CE), se exponen los siguientes datos identificativos del titular de la web:</p><p><strong>Titular:</strong> [TODO: NOMBRE FISCAL O RAZÓN SOCIAL]<br><strong>NIF/CIF:</strong> [TODO: NIF O CIF]<br><strong>Domicilio:</strong> [TODO: DIRECCIÓN FISCAL], Alicante, España.<br><strong>Email de contacto:</strong> info@magic360.es<br><strong>Teléfono:</strong> +34 600 000 000</p>',
                'privacidad' => '<h1>Política de Privacidad</h1><p>De conformidad con el Reglamento General de Protección de Datos (RGPD) UE 2016/679 y la LOPDGDD 3/2018, los datos personales facilitados a través del formulario de contacto serán tratados por [TODO: NOMBRE FISCAL] con la finalidad de gestionar las solicitudes de presupuesto e información sobre los servicios de alquiler de cabina 360 en Alicante.</p><p>No se cederán datos a terceros salvo obligación legal. Puedes ejercer tus derechos de acceso, rectificación, supresión y oposición escribiendo a info@magic360.es.</p>',
                'cookies' => '<h1>Política de Cookies</h1><p>Este sitio web utiliza únicamente cookies técnicas estrictamente necesarias para el correcto funcionamiento de la página y el procesamiento de tus solicitudes. No utilizamos cookies de terceros ni cookies de seguimiento publicitario sin tu consentimiento expreso.</p>',
                'texto_pie' => '© 2026 Magic360 · Alquiler de cabina 360 en Alicante y la Costa Blanca · +34 600 000 000 · Aviso legal · Privacidad · Cookies',
                'whatsapp_mensaje' => 'Hola, quiero información para alquilar la cabina 360 en Alicante. Fecha del evento: ... Lugar: ... Horas: ...',
            ]
        );

        // Tarifas
        Tarifa::truncate();
        $tarifas = [
            [
                'nombre' => '1 hora',
                'horas' => 1,
                'precio' => 140.00,
                'precio_desde' => false,
                'incluye' => ['Montaje y desmontaje incluido', 'Operador técnico presencial', 'Vídeos ilimitados durante la sesión', 'Plantilla de vídeo básica personalizada'],
                'destacada' => false,
                'orden' => 1,
                'visible' => true,
            ],
            [
                'nombre' => '2 horas',
                'horas' => 2,
                'precio' => 230.00,
                'precio_desde' => false,
                'incluye' => ['Todo lo incluido en la opción de 1 hora', 'Plantilla 100% personalizada (nombres/fecha/logo)', 'Atrezzo divertido y máscaras para fotos'],
                'destacada' => false,
                'orden' => 2,
                'visible' => true,
            ],
            [
                'nombre' => '3 horas',
                'horas' => 3,
                'precio' => 290.00,
                'precio_desde' => false,
                'incluye' => ['Todo lo incluido en la opción de 2 horas', 'Iluminación LED ambiental profesional', 'Carteles divertidos para invitados', 'Descarga directa por QR prioritaria'],
                'destacada' => true, // La más pedida
                'orden' => 3,
                'visible' => true,
            ],
            [
                'nombre' => 'Hora extra',
                'horas' => null,
                'precio' => 60.00,
                'precio_desde' => false,
                'incluye' => ['Se añade a cualquier tarjeta contratada previamente'],
                'destacada' => false,
                'orden' => 4,
                'visible' => true,
            ],
        ];

        foreach ($tarifas as $tarifa) {
            Tarifa::create($tarifa);
        }

        // Zonas (Alicante)
        Zona::truncate();
        $zonas = [
            [
                'nombre' => 'Zona A',
                'descripcion' => 'Alicante ciudad · San Vicente del Raspeig · San Juan · El Campello · Muchamiel',
                'recargo' => 0.00,
                'a_consultar' => false,
                'orden' => 1,
                'visible' => true,
            ],
            [
                'nombre' => 'Zona B',
                'descripcion' => 'Elche · Santa Pola · Crevillente · Villajoyosa · Benidorm · Alcoy · Elda',
                'recargo' => 30.00,
                'a_consultar' => false,
                'orden' => 2,
                'visible' => true,
            ],
            [
                'nombre' => 'Zona C',
                'descripcion' => 'Torrevieja · Dénia · Xàbia · Altea · Calpe y resto de la provincia o fuera de ella',
                'recargo' => 0.00,
                'a_consultar' => true,
                'orden' => 3,
                'visible' => true,
            ],
        ];

        foreach ($zonas as $zona) {
            Zona::create($zona);
        }

        // Servicios (Qué es)
        Servicio::truncate();
        $servicios = [
            [
                'titulo' => 'Vídeo 360º con cámara lenta',
                'descripcion' => 'La plataforma gira alrededor de tus invitados y graba un vídeo de 360 grados con efecto cámara lenta. El resultado parece de cine y se comparte solo.',
                'icono' => 'video-camera',
                'orden' => 1,
                'visible' => true,
            ],
            [
                'titulo' => 'Plantilla con el nombre de tu evento',
                'descripcion' => 'Personalizamos el vídeo con los nombres, la fecha y vuestro estilo: música, colores y texto. Cada vídeo sale con vuestra marca.',
                'icono' => 'paint-brush',
                'orden' => 2,
                'visible' => true,
            ],
            [
                'titulo' => 'Se lo llevan al momento',
                'descripcion' => 'Tus invitados escanean un código QR y se descargan el vídeo en su móvil en segundos. Sin apps, sin esperas y sin límite de descargas.',
                'icono' => 'qr-code',
                'orden' => 3,
                'visible' => true,
            ],
        ];

        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }

        // Pasos (Cómo funciona)
        Paso::truncate();
        $pasos = [
            [
                'numero' => 1,
                'titulo' => 'Llegamos y lo montamos',
                'descripcion' => 'Nos desplazamos a tu zona de Alicante, montamos la cabina y la dejamos lista antes de que lleguen los invitados.',
                'icono' => 'truck',
                'orden' => 1,
            ],
            [
                'numero' => 2,
                'titulo' => 'Tus invitados lo disfrutan',
                'descripcion' => 'Suben a la plataforma, posan y graban. Estamos pendientes de que todo funcione durante todo el evento.',
                'icono' => 'sparkles',
                'orden' => 2,
            ],
            [
                'numero' => 3,
                'titulo' => 'Vídeos al móvil al momento',
                'descripcion' => 'Cada vídeo se personaliza y se puede descargar al instante para compartir en redes sociales esa misma noche.',
                'icono' => 'phone',
                'orden' => 3,
            ],
        ];

        foreach ($pasos as $paso) {
            Paso::create($paso);
        }

        // Extras
        Extra::truncate();
        $extras = [
            [
                'nombre' => 'Pistola de Confeti o Burbujas',
                'precio' => 35.00,
                'descripcion' => 'Crea un efecto visual impactante y súper fotogénico en las tomas 360.',
                'orden' => 1,
                'visible' => true,
            ],
            [
                'nombre' => 'Pack Atrezzo y Máscaras VIP',
                'precio' => 25.00,
                'descripcion' => 'Sombreros, gafas gigantes, atrezzo luminoso LED y elementos temáticos.',
                'orden' => 2,
                'visible' => true,
            ],
            [
                'nombre' => 'Galería Web Privada 1 Año',
                'precio' => 20.00,
                'descripcion' => 'Acceso online permanente para descargar todos los vídeos del evento en calidad HD original.',
                'orden' => 3,
                'visible' => true,
            ],
        ];

        foreach ($extras as $extra) {
            Extra::create($extra);
        }

        // Testimonios
        Testimonio::truncate();
        $testimonios = [
            [
                'nombre' => 'Laura y Carlos',
                'tipo_evento' => 'Boda en Alicante',
                'texto' => '¡Fue el pelotazo de nuestra boda en San Juan! Los invitados no pararon de subirse en toda la noche. La plantilla con la fecha de la boda quedó preciosa y el QR en el acto triunfó.',
                'estrellas' => 5,
                'orden' => 1,
                'visible' => true,
            ],
            [
                'nombre' => 'Alejandro M.',
                'tipo_evento' => 'Fiesta 30 Cumpleaños en Elche',
                'texto' => 'Contratamos la tarifa de 2 horas y fue espectacular. Los chavales del equipo pendientes de todo y guiando a la gente para posar. 100% recomendable.',
                'estrellas' => 5,
                'orden' => 2,
                'visible' => true,
            ],
            [
                'nombre' => 'Empresa InnovaTech',
                'tipo_evento' => 'Evento Corporativo en Benidorm',
                'texto' => 'Buscábamos algo dinámico para la gala de empresa y fue todo un acierto. Los vídeos con nuestro logo se compartieron por todo LinkedIn e Instagram.',
                'estrellas' => 5,
                'orden' => 3,
                'visible' => true,
            ],
        ];

        foreach ($testimonios as $testimonio) {
            Testimonio::create($testimonio);
        }

        // Preguntas Frecuentes
        Pregunta::truncate();
        $preguntas = [
            [
                'pregunta' => '¿Cuánto cuesta alquilar una cabina 360 en Alicante?',
                'respuesta' => 'Depende de las horas y de la distancia. Nuestras tarifas empiezan en 140 € e incluyen montaje, operador y vídeos ilimitados. En la sección de precios ves el total al momento.',
                'orden' => 1,
                'visible' => true,
            ],
            [
                'pregunta' => '¿Cuántas horas necesito para mi evento?',
                'respuesta' => 'Para una boda o una fiesta con muchos invitados en Alicante, lo habitual son 3 horas. Para un cumpleaños o un evento pequeño, 2 horas suelen bastar. Siempre puedes añadir horas extra.',
                'orden' => 2,
                'visible' => true,
            ],
            [
                'pregunta' => '¿Cuántos invitados pueden grabar?',
                'respuesta' => 'Los que quieras: no hay límite de vídeos ni de descargas. Cada vídeo tarda menos de un minuto.',
                'orden' => 3,
                'visible' => true,
            ],
            [
                'pregunta' => '¿Cuánto espacio necesitáis?',
                'respuesta' => 'Un espacio de unos 3x3 metros, con corriente eléctrica cerca. Nos adaptamos a casi cualquier salón, terraza o jardín.',
                'orden' => 4,
                'visible' => true,
            ],
            [
                'pregunta' => '¿Se puede personalizar el vídeo?',
                'respuesta' => 'Sí: con los nombres, la fecha, vuestros colores y la música que elijáis. Te enseñamos una prueba antes del evento si quieres.',
                'orden' => 5,
                'visible' => true,
            ],
            [
                'pregunta' => '¿Os desplazáis fuera de Alicante?',
                'respuesta' => 'Sí, nos desplazamos por Alicante, la Costa Blanca y alrededores. El precio varía según la distancia: elige tu zona en la sección de precios y lo ves al momento.',
                'orden' => 6,
                'visible' => true,
            ],
            [
                'pregunta' => '¿Qué pasa si llueve o hay un imprevisto?',
                'respuesta' => 'La cabina funciona en interior y en exterior cubierto. Si hay que cambiar de fecha por causas graves, se cambia sin coste avisando con antelación.',
                'orden' => 7,
                'visible' => true,
            ],
            [
                'pregunta' => '¿Cómo se reserva?',
                'respuesta' => 'Rellenas el formulario o nos escribes por WhatsApp, te confirmamos disponibilidad ese mismo día y con el anticipo queda reservada la fecha.',
                'orden' => 8,
                'visible' => true,
            ],
        ];

        foreach ($preguntas as $pregunta) {
            Pregunta::create($pregunta);
        }

        // Media
        Media::truncate();
        $medias = [
            [
                'titulo' => 'Cabina 360 en boda en Alicante',
                'tipo' => 'video',
                'url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'miniatura' => null,
                'orden' => 1,
                'visible' => true,
            ],
            [
                'titulo' => 'Videomatón 360 en evento de empresa en Alicante',
                'tipo' => 'video',
                'url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
                'miniatura' => null,
                'orden' => 2,
                'visible' => true,
            ],
            [
                'titulo' => 'Plataforma 360 en fiesta de cumpleaños en Elche',
                'tipo' => 'imagen',
                'url' => 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=800&auto=format&fit=crop&q=80',
                'miniatura' => null,
                'orden' => 3,
                'visible' => true,
            ],
            [
                'titulo' => 'Invitados disfrutando de la cabina 360 en Benidorm',
                'tipo' => 'imagen',
                'url' => 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=800&auto=format&fit=crop&q=80',
                'miniatura' => null,
                'orden' => 4,
                'visible' => true,
            ],
        ];

        foreach ($medias as $item) {
            Media::create($item);
        }
    }
}
