<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Solicitud de Presupuesto - Magic360</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #03010E; color: #ffffff; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #0B0C17; border: 1px solid #202128; border-radius: 16px; padding: 30px;">
        <h2 style="color: #FF9500; margin-top: 0;">⚡ Nueva Solicitud de Cabina 360</h2>
        <p>Se ha recibido una nueva solicitud desde la web:</p>

        @if(!empty($presupuesto))
            <div style="background-color: #121324; border: 1px solid #FFD400; border-radius: 12px; padding: 14px 18px; margin: 15px 0;">
                <p style="margin: 0 0 6px 0; color: #FFD400; font-weight: bold; font-size: 13px;">
                    PRESUPUESTO GENERADO: {{ $presupuesto->numero }}
                </p>
                <p style="margin: 0 0 6px 0; font-size: 14px; color: #ffffff;">
                    <strong>Total Presupuestado:</strong> {{ number_format($presupuesto->total, 2, ',', '.') }} € (IVA inc.)
                </p>
                <div style="margin-top: 8px;">
                    <a href="{{ URL::signedRoute('presupuesto.pdf', ['presupuesto' => $presupuesto->id]) }}"
                       style="background: #024EFF; color: #ffffff; padding: 8px 16px; border-radius: 20px; text-decoration: none; font-weight: bold; font-size: 12px; display: inline-block;">
                        📄 Ver / Descargar PDF Adjunto
                    </a>
                </div>
            </div>
        @endif

        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #817E84;">Cliente:</td><td style="padding: 8px 0; border-bottom: 1px solid #202128; font-weight: bold; color: #ffffff;">{{ $mensaje->nombre }}</td></tr>
            <tr><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #817E84;">Teléfono:</td><td style="padding: 8px 0; border-bottom: 1px solid #202128; font-weight: bold; color: #ffffff;"><a href="tel:{{ $mensaje->telefono }}" style="color: #937AFF;">{{ $mensaje->telefono }}</a></td></tr>
            <tr><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #817E84;">Email:</td><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #ffffff;">{{ $mensaje->email }}</td></tr>
            <tr><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #817E84;">Fecha Evento:</td><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #ffffff;">{{ $mensaje->fecha_evento ? $mensaje->fecha_evento->format('d/m/Y') : 'Sin especificar' }}</td></tr>
            <tr><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #817E84;">Ciudad:</td><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #ffffff;">{{ $mensaje->ciudad ?? 'N/D' }}</td></tr>
            <tr><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #817E84;">Tipo Evento:</td><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #ffffff;">{{ $mensaje->tipo_evento ?? 'N/D' }}</td></tr>
            <tr><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #817E84;">Horas / Zona:</td><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #ffffff;">{{ $mensaje->horas }} en {{ $mensaje->zona }}</td></tr>
            <tr><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #817E84;">Mensaje:</td><td style="padding: 8px 0; border-bottom: 1px solid #202128; color: #ffffff;">{{ $mensaje->mensaje }}</td></tr>
        </table>
        <div style="margin-top: 30px; text-align: center;">
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $mensaje->telefono) }}" style="background-color: #25D366; color: white; padding: 12px 24px; border-radius: 30px; text-decoration: none; font-weight: bold; display: inline-block;">Abrir Chat WhatsApp</a>
        </div>
    </div>
</body>
</html>
