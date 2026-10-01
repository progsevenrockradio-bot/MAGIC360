<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mensaje;
use App\Models\Cliente;
use Illuminate\Support\Facades\Mail;
use App\Mail\AcuseClienteContactoMail;
use App\Mail\AvisoNuevoContactoMail;
use Illuminate\Support\Carbon;

class ContactoController extends Controller
{
    public function __invoke(Request $request)
    {
        // 5. Trampa anti-spam (honeypot)
        if ($request->filled('website_url')) {
            return redirect()->back()->with('error', 'Detectado posible SPAM.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:50',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'mensaje' => 'nullable|string',
            'acepta_privacidad' => 'accepted'
        ], [
            'fecha.required' => 'Debes elegir una fecha.',
            'fecha.date' => 'La fecha no es válida.',
        ]);

        // 4. No menos de 48h
        $fechaElegida = Carbon::parse($request->fecha . ' ' . $request->hora, 'Europe/Madrid');
        if ($fechaElegida->isPast() || $fechaElegida->diffInHours(now('Europe/Madrid')) < 48) {
            return redirect()->back()->withErrors(['fecha' => 'Las reservas deben hacerse con al menos 48 horas de antelación.'])->withInput();
        }

        // 2. Guardar Cliente siempre
        $cliente = Cliente::desdeContacto([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
        ]);

        // Crear Mensaje (Solicitud)
        $mensaje = Mensaje::create([
            'nombre' => $cliente->nombre,
            'email' => $cliente->email,
            'telefono' => $cliente->telefono,
            'asunto' => 'Nueva Solicitud de Reserva: ' . $fechaElegida->format('d/m/Y'),
            'mensaje' => "Fecha solicitada: " . $fechaElegida->format('d/m/Y H:i') . "\n\n" . $request->mensaje,
            'leido' => false,
        ]);

        // 6. Aviso por correo a magic360.es@gmail.com y al cliente
        Mail::to('magic360.es@gmail.com')->send(new AvisoNuevoContactoMail($mensaje));
        Mail::to($cliente->email)->send(new AcuseClienteContactoMail($mensaje));

        return redirect()->back()->with('success', '¡Solicitud recibida! Te contactaremos muy pronto para confirmarla.');
    }
}
