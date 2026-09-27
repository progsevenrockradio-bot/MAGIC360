<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactoRequest;
use App\Mail\AcuseClienteContactoMail;
use App\Mail\AvisoNuevoContactoMail;
use App\Models\Ajuste;
use App\Models\Mensaje;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ContactoController extends Controller
{
    public function __invoke(ContactoRequest $request): RedirectResponse
    {
        // Rate limiting: max 5 submissions per IP every 10 minutes
        $key = 'contacto-form:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->withErrors([
                'rate_limit' => "Has enviado demasiadas solicitudes. Por favor, espera {$seconds} segundos antes de volver a intentarlo.",
            ])->withInput();
        }
        RateLimiter::hit($key, 600);

        // Save to database always
        $mensaje = Mensaje::create([
            'nombre' => $request->validated('nombre'),
            'telefono' => $request->validated('telefono'),
            'email' => $request->validated('email'),
            'fecha_evento' => $request->validated('fecha_evento'),
            'ciudad' => $request->validated('ciudad'),
            'tipo_evento' => $request->validated('tipo_evento'),
            'horas' => $request->validated('horas'),
            'zona' => $request->validated('zona'),
            'mensaje' => $request->validated('mensaje'),
            'ip' => $request->ip(),
            'user_agent' => substr($request->userAgent() ?? '', 0, 255),
            'atendido' => false,
            'creado_en' => now(),
        ]);

        $ajuste = Ajuste::first();
        $emailAvisos = $ajuste?->email_avisos ?? config('mail.from.address');

        // Send notifications wrapped in try-catch so failure doesn't break user flow
        try {
            if (! empty($emailAvisos)) {
                Mail::to($emailAvisos)->send(new AvisoNuevoContactoMail($mensaje));
            }
            if (! empty($mensaje->email)) {
                Mail::to($mensaje->email)->send(new AcuseClienteContactoMail($mensaje));
            }
        } catch (\Throwable $e) {
            Log::error('Error al enviar emails de contacto: '.$e->getMessage());
        }

        return back()->with('exito', '¡Solicitud enviada correctamente! Te responderemos en menos de 24 horas.');
    }
}
