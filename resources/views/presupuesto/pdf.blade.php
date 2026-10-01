<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Presupuesto {{ $presupuesto->numero }} · Magic360</title>
    <style>
        @page {
            margin: 28px 32px 30px 32px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #2D3748;
            line-height: 1.45;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #024EFF;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }
        .brand-title {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: -0.5px;
            color: #0A0B14;
            margin: 0;
        }
        .brand-highlight {
            color: #FF9500;
        }
        .brand-slogan {
            font-size: 10px;
            color: #718096;
            margin-top: 3px;
        }
        .budget-badge {
            text-align: right;
        }
        .budget-title {
            font-size: 18px;
            font-weight: 800;
            color: #024EFF;
            text-transform: uppercase;
            margin: 0;
        }
        .budget-num {
            font-size: 13px;
            font-weight: bold;
            color: #1A202C;
            margin-top: 3px;
        }
        .budget-date {
            font-size: 10px;
            color: #718096;
            margin-top: 2px;
        }
        .info-grid {
            width: 100%;
            margin-bottom: 18px;
        }
        .info-box {
            width: 48%;
            background-color: #F7FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 8px;
            padding: 10px 12px;
            vertical-align: top;
        }
        .info-box-title {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #024EFF;
            border-bottom: 1px solid #E2E8F0;
            padding-bottom: 4px;
            margin-bottom: 6px;
        }
        .info-row {
            margin-bottom: 3px;
        }
        .info-label {
            font-weight: bold;
            color: #4A5568;
            display: inline-block;
            width: 75px;
        }
        .info-value {
            color: #1A202C;
        }
        .table-breakdown {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        .table-breakdown th {
            background-color: #0A0B14;
            color: #FFFFFF;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 8px 10px;
            text-align: left;
        }
        .table-breakdown th.text-right, .table-breakdown td.text-right {
            text-align: right;
        }
        .table-breakdown th.text-center, .table-breakdown td.text-center {
            text-align: center;
        }
        .table-breakdown td {
            padding: 8px 10px;
            border-bottom: 1px solid #E2E8F0;
            font-size: 10.5px;
        }
        .table-breakdown tr:nth-child(even) td {
            background-color: #F8FAFC;
        }
        .concept-title {
            font-weight: bold;
            color: #1A202C;
        }
        .concept-desc {
            font-size: 9.5px;
            color: #718096;
            margin-top: 2px;
        }
        .total-container {
            width: 100%;
            margin-bottom: 20px;
        }
        .total-box {
            float: right;
            width: 250px;
            background: #0A0B14;
            border-radius: 8px;
            padding: 12px 16px;
            color: #FFFFFF;
            text-align: right;
        }
        .total-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #FFD400;
            font-weight: bold;
        }
        .total-amount {
            font-size: 24px;
            font-weight: 900;
            color: #FFFFFF;
            margin-top: 4px;
        }
        .total-tax-note {
            font-size: 9px;
            color: #A0AEC0;
            margin-top: 2px;
        }
        .clear {
            clear: both;
        }
        .includes-section {
            background-color: #F7FAFC;
            border: 1px solid #CBD5E0;
            border-left: 4px solid #FF9500;
            border-radius: 6px;
            padding: 10px 14px;
            margin-bottom: 14px;
        }
        .section-heading {
            font-size: 10.5px;
            font-weight: 800;
            text-transform: uppercase;
            color: #1A202C;
            margin-bottom: 6px;
        }
        .includes-list {
            margin: 0;
            padding-left: 16px;
            font-size: 10px;
            color: #4A5568;
        }
        .includes-list li {
            margin-bottom: 3px;
        }
        .conditions-section {
            background-color: #FFFDF5;
            border: 1px solid #ECC94B;
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 9.5px;
            color: #744210;
            margin-bottom: 14px;
        }
        .conditions-section ul {
            margin: 4px 0 0 0;
            padding-left: 16px;
        }
        .conditions-section li {
            margin-bottom: 2px;
        }
        .footer-note {
            text-align: center;
            font-size: 9px;
            color: #718096;
            border-top: 1px solid #E2E8F0;
            padding-top: 8px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

    {{-- Cabecera con datos de la empresa y número de presupuesto --}}
    <table class="header-table" cellpadding="0" cellspacing="0">
        <tr>
            <td style="vertical-align: top;">
                <h1 class="brand-title">MAGIC<span class="brand-highlight">360</span></h1>
                <div class="brand-slogan">{{ $ajuste->eslogan ?? 'Alquiler de cabina 360º para bodas y eventos' }}</div>
                <div style="font-size: 9.5px; color: #4A5568; margin-top: 6px;">
                    <strong>{{ $ajuste->nombre_marca ?? 'Magic360' }}</strong> · {{ $ajuste->ciudad ?? 'Alicante' }} ({{ $ajuste->zona_cobertura ?? 'Costa Blanca' }})<br>
                    Teléfono: {{ $ajuste->telefono }} · WhatsApp: +{{ $ajuste->whatsapp }}<br>
                    Email: {{ $ajuste->email_contacto }}
                </div>
            </td>
            <td class="budget-badge" style="vertical-align: top;">
                <div class="budget-title">Presupuesto</div>
                <div class="budget-num">{{ $presupuesto->numero }}</div>
                <div class="budget-date"><strong>Fecha:</strong> {{ $presupuesto->fecha ? $presupuesto->fecha->format('d/m/Y') : date('d/m/Y') }}</div>
                <div class="budget-date" style="color: #024EFF; font-weight: bold;"><strong>Validez:</strong> 15 días (hasta {{ $presupuesto->fecha_validez ? $presupuesto->fecha_validez->format('d/m/Y') : now()->addDays(15)->format('d/m/Y') }})</div>
            </td>
        </tr>
    </table>

    {{-- Datos del Cliente y del Evento --}}
    <table class="info-grid" cellpadding="0" cellspacing="0">
        <tr>
            <td class="info-box">
                <div class="info-box-title">Datos del Cliente</div>
                <div class="info-row"><span class="info-label">Nombre:</span> <span class="info-value"><strong>{{ $presupuesto->cliente_nombre }}</strong></span></div>
                <div class="info-row"><span class="info-label">Teléfono:</span> <span class="info-value">{{ $presupuesto->cliente_telefono }}</span></div>
                <div class="info-row"><span class="info-label">Email:</span> <span class="info-value">{{ $presupuesto->cliente_email }}</span></div>
            </td>
            <td style="width: 4%;"></td>
            <td class="info-box">
                <div class="info-box-title">Datos del Evento</div>
                <div class="info-row"><span class="info-label">Tipo:</span> <span class="info-value"><strong>{{ $presupuesto->tipo_evento ?? 'Celebración' }}</strong></span></div>
                <div class="info-row"><span class="info-label">Fecha:</span> <span class="info-value">{{ $presupuesto->fecha_evento ? $presupuesto->fecha_evento->format('d/m/Y') : 'A concretar' }}</span></div>
                <div class="info-row"><span class="info-label">Población:</span> <span class="info-value">{{ $presupuesto->ciudad ?? $ajuste->ciudad }}</span></div>
            </td>
        </tr>
    </table>

    {{-- Tabla de desglose --}}
    @php
        $desglose = $presupuesto->desglose ?? [];
        $tarifa = $desglose['tarifa'] ?? [];
        $zonaInfo = $desglose['zona'] ?? null;
        $recargoZona = $desglose['recargo_zona'] ?? 0;
        $horasExtraViaje = $desglose['horas_extra_viaje'] ?? [];
        $extras = $desglose['extras'] ?? [];
        $nocturnidad = $desglose['nocturnidad'] ?? [];
        $aConsultar = !empty($desglose['a_consultar']);
    @endphp

    <table class="table-breakdown" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th style="width: 60%;">Concepto / Servicio</th>
                <th class="text-center" style="width: 15%;">Horas / Ud.</th>
                <th class="text-right" style="width: 25%;">Importe (IVA inc.)</th>
            </tr>
        </thead>
        <tbody>
            {{-- Tarifa de servicio --}}
            <tr>
                <td>
                    <div class="concept-title">Alquiler de Cabina 360º — {{ $tarifa['nombre'] ?? ($presupuesto->horas . ' horas') }}</div>
                    <div class="concept-desc">
                        Incluye montaje y desmontaje, operador presencial, vídeos en cámara lenta ilimitados, plantilla personalizada y descarga al móvil al momento.
                    </div>
                </td>
                <td class="text-center">
                    {{ $presupuesto->horas ?? ($tarifa['horas'] ?? 2) }} h
                </td>
                <td class="text-right">
                    <strong>{{ number_format($tarifa['subtotal'] ?? $presupuesto->total, 2, ',', '.') }} €</strong>
                </td>
            </tr>

            {{-- Desplazamiento por tramo de zona --}}
            <tr>
                <td>
                    <div class="concept-title">
                        Desplazamiento — {{ $zonaInfo['nombre'] ?? ($presupuesto->zona?->nombre ?? 'Zona A') }}
                    </div>
                    <div class="concept-desc">
                        @if($aConsultar)
                            Distancia superior al radio estándar. Sujeto a valoración de kilometraje y tiempo.
                        @else
                            {{ $zonaInfo['descripcion'] ?? ($presupuesto->zona?->descripcion ?? 'Desplazamiento dentro del radio estándar incluido (primeros 30 km).') }}
                        @endif
                    </div>
                </td>
                <td class="text-center">1 trayecto</td>
                <td class="text-right">
                    @if($aConsultar)
                        <span style="color: #024EFF; font-weight: bold;">A consultar</span>
                    @elseif($recargoZona > 0)
                        <strong>+{{ number_format($recargoZona, 2, ',', '.') }} €</strong>
                    @else
                        <span style="color: #38A169; font-weight: bold;">0,00 € (Incluido)</span>
                    @endif
                </td>
            </tr>

            {{-- Horas extra de viaje o espera --}}
            @if(!empty($horasExtraViaje['horas']) && $horasExtraViaje['horas'] > 0)
                <tr>
                    <td>
                        <div class="concept-title">Horas adicionales de desplazamiento / espera</div>
                        <div class="concept-desc">Tiempo de espera prolongado en el lugar del evento o regreso en horario especial.</div>
                    </td>
                    <td class="text-center">{{ $horasExtraViaje['horas'] }} h</td>
                    <td class="text-right">+{{ number_format($horasExtraViaje['subtotal'], 2, ',', '.') }} €</td>
                </tr>
            @endif

            {{-- Extras seleccionados --}}
            @if(!empty($extras))
                @foreach($extras as $extra)
                    <tr>
                        <td>
                            <div class="concept-title">Extra: {{ $extra['nombre'] }}</div>
                        </td>
                        <td class="text-center">1 ud.</td>
                        <td class="text-right">+{{ number_format($extra['precio'], 2, ',', '.') }} €</td>
                    </tr>
                @endforeach
            @endif

            {{-- Nocturnidad --}}
            @if(!empty($nocturnidad['aplica']))
                <tr>
                    <td>
                        <div class="concept-title">Recargo por servicio nocturno</div>
                        <div class="concept-desc">Para eventos cuya finalización o desmontaje tiene lugar a partir de las {{ $nocturnidad['desde_hora'] ?? '00:00' }} h.</div>
                    </td>
                    <td class="text-center">1</td>
                    <td class="text-right">+{{ number_format($nocturnidad['importe'], 2, ',', '.') }} €</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- Bloque Total --}}
    <div class="total-container">
        <div class="total-box">
            <div class="total-label">Importe Total Estimado</div>
            <div class="total-amount">
                @if($aConsultar)
                    {{ number_format($presupuesto->total, 2, ',', '.') }} €*
                @else
                    {{ number_format($presupuesto->total, 2, ',', '.') }} €
                @endif
            </div>
            <div class="total-tax-note">
                @if($aConsultar)
                    * Total base sin recargo de desplazamiento (+ suplemento a consultar)
                @else
                    IVA y todos los conceptos especificados incluidos
                @endif
            </div>
        </div>
        <div class="clear"></div>
    </div>

    {{-- Qué incluye el servicio --}}
    <div class="includes-section">
        <div class="section-heading">✓ Qué incluye siempre tu servicio Magic360</div>
        <ul class="includes-list">
            <li><strong>Montaje y desmontaje completo:</strong> llegamos con antelación suficiente para tener todo calibrado e impecable.</li>
            <li><strong>Operador profesional durante todo el evento:</strong> nuestro técnico asiste, guía y anima a tus invitados.</li>
            <li><strong>Grabación y procesado en cámara lenta:</strong> efectos dinámicos de aceleración y reverse para un acabado de vídeo publicitario.</li>
            <li><strong>Plantilla personalizada:</strong> marco con vuestros nombres, fecha, logo o colores temáticos de la fiesta.</li>
            <li><strong>Descarga instantánea:</strong> código QR directo para que los invitados tengan su vídeo en el móvil al instante y lo compartan en redes.</li>
        </ul>
    </div>

    {{-- Condiciones y Reserva --}}
    <div class="conditions-section">
        <strong>Condiciones de contratación y reserva:</strong>
        <ul>
            <li><strong>Reserva de fecha:</strong> Para formalizar el bloqueo de la fecha se requiere un <strong>50 % de señal</strong> en concepto de anticipo.</li>
            <li><strong>Liquidación:</strong> El 50 % restante se abonará antes del inicio del evento o el mismo día según lo acordado.</li>
            <li><strong>Validez del presupuesto:</strong> Este documento tiene una validez de <strong>15 días naturales</strong> desde la fecha de expedición. Transcurrido ese periodo, la disponibilidad de fecha y los precios quedan sujetos a confirmación.</li>
            <li><strong>Requisitos técnicos:</strong> Toma de corriente eléctrica estándar (220V) a menos de 20 metros y una superficie llana de al menos 3x3 metros para la instalación de la plataforma y el perímetro de seguridad.</li>
        </ul>
    </div>

    <div class="footer-note">
        {{ $ajuste->nombre_marca ?? 'Magic360' }} · Alquiler de Cabinas 360 · {{ $ajuste->telefono }} · {{ $ajuste->email_contacto }} · {{ config('app.url') }}
    </div>

</body>
</html>
