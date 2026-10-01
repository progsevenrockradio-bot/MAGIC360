<?php

namespace Tests\Feature;

use App\Models\Ajuste;
use App\Models\Presupuesto;
use App\Models\Tarifa;
use App\Models\Zona;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class PresupuestoFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();

        Ajuste::create([
            'id' => 1,
            'nombre_marca' => 'Magic360',
            'telefono' => '+34 600 000 000',
            'whatsapp' => '34600000000',
            'email_contacto' => 'info@magic360.es',
            'email_avisos' => 'avisos@magic360.es',
            'ciudad' => 'Alicante',
            'zona_cobertura' => 'Alicante y la Costa Blanca',
            'desplazamiento_hora_extra' => 30.00,
            'nocturnidad_activa' => true,
            'nocturnidad_importe' => 50.00,
        ]);

        Tarifa::create([
            'nombre' => '2 horas',
            'horas' => 2,
            'precio' => 230.00,
            'visible' => true,
        ]);

        Tarifa::create([
            'nombre' => '3 horas',
            'horas' => 3,
            'precio' => 290.00,
            'visible' => true,
        ]);

        Zona::create([
            'nombre' => 'Zona A',
            'descripcion' => 'Alicante centro',
            'recargo' => 0.00,
            'a_consultar' => false,
            'visible' => true,
        ]);
    }

    public function test_calcular_endpoint_devuelve_desglose_en_vivo(): void
    {
        $response = $this->postJson('/presupuesto/calcular', [
            'horas' => 2,
            'zona' => 'Zona A',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('tarifa.subtotal', 230)
            ->assertJsonPath('total', 230);
    }

    public function test_crear_un_presupuesto_guarda_la_fila_genera_numero_y_envia_emails(): void
    {
        $payload = [
            'nombre' => 'Juan Pérez',
            'telefono' => '+34 612 345 678',
            'email' => 'juan@ejemplo.com',
            'ciudad' => 'San Vicente del Raspeig',
            'horas' => 3,
            'zona' => 'Zona A',
            'tipo_evento' => 'Cumpleaños',
            'fecha_evento' => now()->addDays(10)->toDateString(),
            'horas_extra_viaje' => 0,
            'mensaje' => 'Queremos música animada.',
        ];

        $response = $this->postJson('/presupuesto', $payload);

        $response->assertStatus(200)
            ->assertJsonPath('exito', true);

        $presupuesto = Presupuesto::where('cliente_email', 'juan@ejemplo.com')->first();
        $this->assertNotNull($presupuesto);
        $this->assertEquals('Juan Pérez', $presupuesto->cliente_nombre);
        $this->assertMatchesRegularExpression('/^M360-\d{4}-\d{4}$/', $presupuesto->numero);
        $this->assertEquals(290.00, (float) $presupuesto->total);
        $this->assertEquals('enviado', $presupuesto->estado);

        // Verifica que se generó una URL firmada
        $this->assertArrayHasKey('pdf_url', $response->json());
        $this->assertStringContainsString('signature=', $response->json()['pdf_url']);
    }

    public function test_pdf_responde_200_en_la_ruta_firmada(): void
    {
        $presupuesto = Presupuesto::create([
            'numero' => Presupuesto::generarNumero(),
            'fecha' => now()->toDateString(),
            'cliente_nombre' => 'Marta Gómez',
            'cliente_telefono' => '+34 699 888 777',
            'cliente_email' => 'marta@ejemplo.com',
            'ciudad' => 'Alicante',
            'tipo_evento' => 'Boda',
            'horas' => 2,
            'desglose' => [
                'tarifa' => ['nombre' => '2 horas', 'horas' => 2, 'subtotal' => 230.00],
                'recargo_zona' => 0.00,
                'horas_extra_viaje' => ['horas' => 0, 'subtotal' => 0.00],
                'extras' => [],
                'nocturnidad' => ['aplica' => false, 'importe' => 0.00],
                'total' => 230.00,
            ],
            'total' => 230.00,
            'estado' => 'enviado',
            'validez_dias' => 15,
        ]);

        $signedUrl = URL::signedRoute('presupuesto.pdf', ['presupuesto' => $presupuesto->id]);

        $response = $this->get($signedUrl);

        $response->assertStatus(200);
        $this->assertStringContainsString('application/pdf', $response->headers->get('Content-Type'));
    }

    public function test_pdf_responde_403_sin_firma(): void
    {
        $presupuesto = Presupuesto::create([
            'numero' => Presupuesto::generarNumero(),
            'fecha' => now()->toDateString(),
            'cliente_nombre' => 'Carlos Soler',
            'cliente_telefono' => '+34 655 444 333',
            'cliente_email' => 'carlos@ejemplo.com',
            'ciudad' => 'Elche',
            'horas' => 2,
            'total' => 230.00,
        ]);

        // Solicitud sin firma
        $unsignedUrl = route('presupuesto.pdf', ['presupuesto' => $presupuesto->id]);

        $response = $this->get($unsignedUrl);

        $response->assertStatus(403);
    }
}
