<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hemos recibido tu solicitud · Magic360</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #03010E; color: #ffffff; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #0B0C17; border: 1px solid #202128; border-radius: 16px; padding: 30px;">
        <h2 style="color: #FF9500; margin-top: 0;">¡Hola, {{ $mensaje->nombre }}! 👋</h2>
        <p>Muchas gracias por contactar con <strong>Magic360</strong>.</p>
        <p>Hemos recibido correctamente tu solicitud de presupuesto para el alquiler de la cabina 360º.</p>

        @if(!empty($presupuesto))
            <div style="background-color: #121324; border: 1px solid #024EFF; border-radius: 12px; padding: 18px 20px; margin: 20px 0;">
                <p style="margin: 0 0 8px 0; color: #FFD400; font-weight: bold; font-size: 14px; text-transform: uppercase;">
                    Presupuesto Nº {{ $presupuesto->numero }}
                </p>
                <p style="margin: 0 0 6px 0; font-size: 13px; color: #CBD5E0;">
                    <strong>Total Estimado:</strong> <span style="font-size: 16px; font-weight: bold; color: #ffffff;">{{ number_format($presupuesto->total, 2, ',', '.') }} €</span> (IVA inc.)
                </p>
                <p style="margin: 0 0 12px 0; font-size: 12px; color: #A0AEC0;">
                    Te adjuntamos el desglose oficial en PDF a este correo electrónico. También puedes descargarlo directamente en cualquier momento en el siguiente botón:
                </p>
                <div style="text-align: center; margin-top: 10px;">
                    <a href="{{ URL::signedRoute('presupuesto.pdf', ['presupuesto' => $presupuesto->id]) }}"
                       style="background: #024EFF; color: #ffffff; padding: 10px 22px; border-radius: 20px; text-decoration: none; font-weight: bold; font-size: 13px; display: inline-block;">
                        📄 Descargar Presupuesto en PDF
                    </a>
                </div>
            </div>
        @endif

        <p>Nuestro equipo comprobará la disponibilidad para tu fecha (<strong>{{ $mensaje->fecha_evento ? $mensaje->fecha_evento->format('d/m/Y') : 'próximo evento' }}</strong>) y te responderemos hoy mismo con la propuesta detallada y el precio final.</p>
        <p>Si tienes prisa o quieres resolver alguna duda al instante, también puedes escribirnos directamente a nuestro WhatsApp:</p>
        <div style="margin-top: 25px; text-align: center;">
            <a href="https://wa.me/34600000000" style="background: linear-gradient(0deg, #4D36D0 0%, #937AFF 100%); color: white; padding: 14px 28px; border-radius: 30px; text-decoration: none; font-weight: bold; display: inline-block;">Escribir por WhatsApp</a>
        </div>
        <p style="margin-top: 30px; font-size: 12px; color: #817E84; text-align: center;">© 2026 Magic360 · Todos los derechos reservados</p>
    </div>
</body>
</html>
