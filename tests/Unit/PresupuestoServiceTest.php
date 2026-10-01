<?php

namespace Tests\Unit;

use App\Models\Ajuste;
use App\Models\Extra;
use App\Models\Tarifa;
use App\Models\Zona;
use App\Services\PresupuestoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PresupuestoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PresupuestoService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PresupuestoService;

        Ajuste::create([
            'id' => 1,
            'nombre_marca' => 'Magic360',
            'desplazamiento_hora_extra' => 30.00,
            'nocturnidad_activa' => true,
            'nocturnidad_desde_hora' => '00:00',
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

        Tarifa::create([
            'nombre' => 'Hora extra',
            'horas' => null,
            'precio' => 60.00,
            'visible' => true,
        ]);

        Zona::create([
            'nombre' => 'Zona A',
            'descripcion' => 'Alicante centro',
            'recargo' => 0.00,
            'a_consultar' => false,
            'visible' => true,
        ]);

        Zona::create([
            'nombre' => 'Zona B',
            'descripcion' => 'Elche',
            'recargo' => 40.00,
            'a_consultar' => false,
            'visible' => true,
        ]);

        Zona::create([
            'nombre' => 'Zona C',
            'descripcion' => 'Más de 2h',
            'recargo' => 0.00,
            'a_consultar' => true,
            'visible' => true,
        ]);

        Extra::create([
            'id' => 1,
            'nombre' => 'Pistola de Confeti',
            'precio' => 35.00,
            'visible' => true,
        ]);

        Extra::create([
            'id' => 2,
            'nombre' => 'Pack Atrezzo VIP',
            'precio' => 25.00,
            'visible' => true,
        ]);
    }

    public function test_tarifa_correcta_por_horas_exactas(): void
    {
        $res = $this->service->calcular([
            'horas' => 2,
            'zona' => 'Zona A',
        ]);

        $this->assertEquals(230.00, $res['tarifa']['subtotal']);
        $this->assertEquals(0, $res['tarifa']['horas_extra']);
        $this->assertEquals(230.00, $res['total']);
    }

    public function test_tarifa_calcula_horas_extra_cuando_no_hay_tarifa_exacta(): void
    {
        // 4 horas: base 3h (290) + 1 hora extra (60) = 350 €
        $res = $this->service->calcular([
            'horas' => 4,
            'zona' => 'Zona A',
        ]);

        $this->assertEquals(350.00, $res['tarifa']['subtotal']);
        $this->assertEquals(1, $res['tarifa']['horas_extra']);
        $this->assertEquals(350.00, $res['total']);
    }

    public function test_aplica_recargo_por_zona(): void
    {
        $res = $this->service->calcular([
            'horas' => 2,
            'zona' => 'Zona B',
        ]);

        $this->assertEquals(40.00, $res['recargo_zona']);
        $this->assertFalse($res['a_consultar']);
        $this->assertEquals(270.00, $res['total']); // 230 + 40
    }

    public function test_zona_a_consultar_no_suma_recargo_y_marca_a_consultar(): void
    {
        $res = $this->service->calcular([
            'horas' => 2,
            'zona' => 'Zona C',
        ]);

        $this->assertEquals(0.00, $res['recargo_zona']);
        $this->assertTrue($res['a_consultar']);
        $this->assertEquals(230.00, $res['total']); // 230 + 0
    }

    public function test_aplica_horas_extra_de_viaje(): void
    {
        // 2 horas de servicio (230) + 2 horas extra de viaje a 30 €/h (60) = 290 €
        $res = $this->service->calcular([
            'horas' => 2,
            'zona' => 'Zona A',
            'horas_extra_viaje' => 2,
        ]);

        $this->assertEquals(2, $res['horas_extra_viaje']['horas']);
        $this->assertEquals(60.00, $res['horas_extra_viaje']['subtotal']);
        $this->assertEquals(290.00, $res['total']);
    }

    public function test_suma_extras_correctamente(): void
    {
        // 2h (230) + Extra 1 (35) + Extra 2 (25) = 290 €
        $res = $this->service->calcular([
            'horas' => 2,
            'zona' => 'Zona A',
            'extras' => [1, 2],
        ]);

        $this->assertCount(2, $res['extras']);
        $this->assertEquals(60.00, $res['extras_subtotal']);
        $this->assertEquals(290.00, $res['total']);
    }

    public function test_aplica_recargo_de_nocturnidad(): void
    {
        // 2h (230) + nocturnidad (50) = 280 €
        $res = $this->service->calcular([
            'horas' => 2,
            'zona' => 'Zona A',
            'nocturnidad' => true,
        ]);

        $this->assertTrue($res['nocturnidad']['aplica']);
        $this->assertEquals(50.00, $res['nocturnidad']['importe']);
        $this->assertEquals(280.00, $res['total']);
    }

    public function test_calculo_total_final_completo(): void
    {
        // 3h (290) + Zona B (40) + 1h extra viaje (30) + Extra 2 (25) + Nocturnidad (50) = 435 €
        $res = $this->service->calcular([
            'horas' => 3,
            'zona' => 'Zona B',
            'horas_extra_viaje' => 1,
            'extras' => [2],
            'nocturnidad' => true,
        ]);

        $this->assertEquals(290.00, $res['tarifa']['subtotal']);
        $this->assertEquals(40.00, $res['recargo_zona']);
        $this->assertEquals(30.00, $res['horas_extra_viaje']['subtotal']);
        $this->assertEquals(25.00, $res['extras_subtotal']);
        $this->assertEquals(50.00, $res['nocturnidad']['importe']);
        $this->assertEquals(435.00, $res['total']);
    }
}
