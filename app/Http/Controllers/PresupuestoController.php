<?php

namespace App\Http\Controllers;

use App\Http\Requests\PresupuestoStoreRequest;
use App\Mail\AcuseClienteContactoMail;
use App\Mail\AvisoNuevoContactoMail;
use App\Models\Ajuste;
use App\Models\Mensaje;
use App\Models\Presupuesto;
use App\Services\PresupuestoService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;

class PresupuestoController extends Controller
{
    public function __construct(
        protected PresupuestoService $presupuestoService
    ) {}

    /**
     * Calcula el desglose en vivo para el simulador / formulario interactivo.
     */
    public function calcular(Request $request): JsonResponse
    {
        $desglose = $this->presupuestoService->calcular($request->all());

        return response()->json($desglose);
    }

    /**
     * Guarda el presupuesto, genera número y PDF, envía correos y devuelve URL firmada.
     */
    public function store(PresupuestoStoreRequest $request)
    {
        // Rate limiting anti-spam
        $key = 'presupuesto-submit:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 8)) {
            $seconds = RateLimiter::availableIn($key);
            if ($request->expectsJson()) {
                return response()->json([
                    'exito' => false,
                    'mensaje' => "Has enviado demasiadas solicitudes. Por favor, espera {$seconds} segundos.",
                ], 429);
            }

            return back()->withErrors([
                'rate_limit' => "Demasiadas solicitudes. Espera {$seconds} segundos.",
            ])->withInput();
        }
        RateLimiter::hit($key, 600);

        // 1. Calcular desglose con el servicio único de verdad
        $desglose = $this->presupuestoService->calcular($request->all());

        // 2. Crear registro de Presupuesto
        $presupuesto = Presupuesto::create([
            'fecha' => now()->toDateString(),
            'fecha_evento' => $request->validated('fecha_evento'),
            'cliente_nombre' => $request->validated('nombre'),
            'cliente_telefono' => $request->validated('telefono'),
            'cliente_email' => $request->validated('email'),
            'ciudad' => $request->validated('ciudad'),
            'tipo_evento' => $request->validated('tipo_evento') ?? 'Evento',
            'horas' => $desglose['tarifa']['horas'] ?? 2,
            'zona_id' => $desglose['zona']['id'] ?? null,
            'horas_extra_viaje' => $desglose['horas_extra_viaje']['horas'] ?? 0,
            'desglose' => $desglose,
            'total' => $desglose['total'] ?? 0,
            'estado' => 'enviado',
            'notas' => $request->validated('mensaje'),
            'validez_dias' => 15,
        ]);

        // 3. Crear registro en Mensaje para histórico y compatibilidad con el panel
        $mensaje = Mensaje::create([
            'nombre' => $presupuesto->cliente_nombre,
            'telefono' => $presupuesto->cliente_telefono,
            'email' => $presupuesto->cliente_email,
            'fecha_evento' => $presupuesto->fecha_evento,
            'ciudad' => $presupuesto->ciudad,
            'tipo_evento' => $presupuesto->tipo_evento,
            'horas' => ($presupuesto->horas ?? 2).' horas',
            'zona' => $desglose['zona']['nombre'] ?? 'Zona A',
            'mensaje' => $presupuesto->notas ?? "Presupuesto web {$presupuesto->numero}",
            'ip' => $request->ip(),
            'user_agent' => substr($request->userAgent() ?? '', 0, 255),
            'atendido' => false,
            'creado_en' => now(),
        ]);

        // 4. Enviar emails con PDF adjunto
        $ajuste = Ajuste::first();
        $emailAvisos = $ajuste?->email_avisos ?? config('mail.from.address');

        try {
            if (! empty($emailAvisos)) {
                Mail::to($emailAvisos)->send(new AvisoNuevoContactoMail($mensaje, $presupuesto));
            }
            if (! empty($presupuesto->cliente_email)) {
                Mail::to($presupuesto->cliente_email)->send(new AcuseClienteContactoMail($mensaje, $presupuesto));
            }
        } catch (\Throwable $e) {
            Log::error('Error al enviar emails de presupuesto: '.$e->getMessage());
        }

        // 5. Generar URL firmada del PDF
        $pdfUrl = URL::signedRoute('presupuesto.pdf', ['presupuesto' => $presupuesto->id]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'exito' => true,
                'mensaje' => '¡Presupuesto generado con éxito!',
                'presupuesto_id' => $presupuesto->id,
                'numero' => $presupuesto->numero,
                'total' => $presupuesto->total,
                'pdf_url' => $pdfUrl,
            ]);
        }

        return redirect()->away($pdfUrl);
    }

    /**
     * Descarga el PDF del presupuesto a través de la ruta firmada.
     */
    public function descargarPdf(Request $request, Presupuesto $presupuesto): Response
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Enlace de descarga no válido o caducado.');
        }

        $ajuste = Ajuste::firstOrCreate(['id' => 1]);

        $pdf = Pdf::loadView('presupuesto.pdf', [
            'presupuesto' => $presupuesto,
            'ajuste' => $ajuste,
        ]);

        return $pdf->download("Presupuesto-{$presupuesto->numero}.pdf");
    }
}
