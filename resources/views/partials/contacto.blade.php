<section id="contacto" class="py-20 bg-[#0A0B14] border-t border-[var(--color-azul)]/20 relative">
    <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold text-[var(--color-azul-claro)] tracking-widest uppercase mb-2 block">Presupuesto en vivo</span>
            <h2 class="text-3xl md:text-5xl font-black text-gradient-warm mb-4">
                Configura tu cabina 360 en {{ $ajuste->ciudad }}
            </h2>
            <p class="text-secondary-custom text-base md:text-lg">
                Elige tus horas, tu zona y tus extras para ver el desglose exacto al instante. Descarga tu presupuesto oficial en PDF o envíanos tu solicitud en un clic.
            </p>
        </div>

        @if(session('exito'))
            <div class="mb-8 p-6 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 text-center font-semibold text-lg animate-bounce">
                🎉 {{ session('exito') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-8 p-6 rounded-2xl bg-red-500/20 border border-red-500/40 text-red-300 text-sm">
                <p class="font-bold mb-2">Por favor, corrige los siguientes errores:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div id="pdf-alert-message" class="hidden mb-6 p-4 rounded-2xl text-sm font-medium"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            {{-- Formulario --}}
            <div class="lg:col-span-8 card-glass p-8 md:p-10 rounded-3xl">
                <form id="presupuesto-form" action="{{ route('contacto.send') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Honeypot anti-spam field --}}
                    <div class="hidden" style="display: none !important;">
                        <input type="text" name="web" value="">
                    </div>

                    {{-- Datos del Cliente --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="form-nombre" class="block text-xs font-bold text-gray-300 uppercase mb-2">Nombre completo *</label>
                            <input type="text" id="form-nombre" name="nombre" value="{{ old('nombre') }}" required
                                   placeholder="Tu nombre y apellidos"
                                   class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white placeholder-gray-500 focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                        </div>

                        <div>
                            <label for="form-telefono" class="block text-xs font-bold text-gray-300 uppercase mb-2">Teléfono *</label>
                            <input type="tel" id="form-telefono" name="telefono" value="{{ old('telefono') }}" required
                                   placeholder="Ej: {{ $ajuste->telefono ?? '600 123 456' }}"
                                   class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white placeholder-gray-500 focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="form-email" class="block text-xs font-bold text-gray-300 uppercase mb-2">Correo electrónico *</label>
                            <input type="email" id="form-email" name="email" value="{{ old('email') }}" required
                                   placeholder="tu@email.com"
                                   class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white placeholder-gray-500 focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="form-fecha" class="block text-xs font-bold text-gray-300 uppercase mb-2">Fecha *</label>
                                <input type="date" id="form-fecha" name="fecha" value="{{ old('fecha') }}" min="{{ date('Y-m-d') }}" required
                                       class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                            </div>
                            <div>
                                <label for="form-hora" class="block text-xs font-bold text-gray-300 uppercase mb-2">Hora de inicio *</label>
                                <input type="time" id="form-hora" name="hora" value="{{ old('hora', '18:00') }}" required
                                       class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="form-ciudad" class="block text-xs font-bold text-gray-300 uppercase mb-2">Ciudad / Población *</label>
                            <input type="text" id="form-ciudad" name="ciudad" value="{{ old('ciudad', $ajuste->ciudad) }}" required
                                   placeholder="Ej: San Juan, Elche, Alicante..."
                                   class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white placeholder-gray-500 focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                        </div>

                        <div>
                            <label for="form-tipo" class="block text-xs font-bold text-gray-300 uppercase mb-2">Tipo de evento</label>
                            <select id="form-tipo" name="tipo_evento"
                                    class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm cursor-pointer">
                                <option value="Boda" {{ old('tipo_evento') == 'Boda' ? 'selected' : '' }}>Boda</option>
                                <option value="Cumpleaños / Fiesta" {{ old('tipo_evento') == 'Cumpleaños / Fiesta' ? 'selected' : '' }}>Cumpleaños / Fiesta</option>
                                <option value="Evento de Empresa" {{ old('tipo_evento') == 'Evento de Empresa' ? 'selected' : '' }}>Evento de Empresa</option>
                                <option value="Comunión / Bautizo" {{ old('tipo_evento') == 'Comunión / Bautizo' ? 'selected' : '' }}>Comunión / Bautizo</option>
                                <option value="Otro evento" {{ old('tipo_evento') == 'Otro evento' ? 'selected' : '' }}>Otro evento</option>
                            </select>
                        </div>
                    </div>

                    {{-- Configuración del Presupuesto (Horas, Zona, Desplazamiento Extra) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="form-horas" class="block text-xs font-bold text-gray-300 uppercase mb-2">Horas de servicio *</label>
                            <select id="form-horas" name="horas"
                                    class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm cursor-pointer">
                                @foreach($tarifas->whereNotNull('horas') as $t)
                                    <option value="{{ $t->horas }}" data-nombre="{{ $t->nombre }}" {{ $loop->iteration === 2 ? 'selected' : '' }}>
                                        {{ $t->nombre }} ({{ number_format($t->precio, 0) }} €)
                                    </option>
                                @endforeach
                                <option value="4" data-nombre="4 horas">4 horas</option>
                                <option value="5" data-nombre="5 horas">5 horas</option>
                                <option value="6" data-nombre="Toda la noche">Toda la noche</option>
                            </select>
                        </div>

                        <div>
                            <label for="form-zona" class="block text-xs font-bold text-gray-300 uppercase mb-2">Zona de desplazamiento *</label>
                            <select id="form-zona" name="zona"
                                    class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm cursor-pointer">
                                @foreach($zonas as $index => $z)
                                    <option value="{{ $z->nombre }}" data-id="{{ $z->id }}" data-recargo="{{ $z->recargo }}" data-consultar="{{ $z->a_consultar ? '1' : '0' }}" {{ $index === 0 ? 'selected' : '' }}>
                                        {{ $z->nombre }} ({{ $z->a_consultar ? 'A consultar' : ($z->recargo > 0 ? '+' . number_format($z->recargo, 0) . ' €' : '0 € incluido') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Horas extra de viaje/espera y Nocturnidad --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                        <div>
                            <label for="form-horas-extra-viaje" class="block text-xs font-bold text-gray-300 uppercase mb-2">
                                Horas extra de viaje / espera
                            </label>
                            <select id="form-horas-extra-viaje" name="horas_extra_viaje"
                                    class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm cursor-pointer">
                                <option value="0">0 horas (estándar)</option>
                                <option value="1">+1 hora (+{{ number_format($ajuste->desplazamiento_hora_extra ?? 30, 0) }} €)</option>
                                <option value="2">+2 horas (+{{ number_format(($ajuste->desplazamiento_hora_extra ?? 30) * 2, 0) }} €)</option>
                                <option value="3">+3 horas (+{{ number_format(($ajuste->desplazamiento_hora_extra ?? 30) * 3, 0) }} €)</option>
                                <option value="4">+4 horas (+{{ number_format(($ajuste->desplazamiento_hora_extra ?? 30) * 4, 0) }} €)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-300 uppercase mb-2">Horario Nocturno</label>
                            <label class="flex items-center gap-3 p-3.5 bg-black/60 border border-[var(--color-azul)]/40 rounded-full cursor-pointer hover:border-[var(--color-dorado)] transition-colors">
                                <input type="checkbox" id="form-nocturnidad" name="nocturnidad" value="1"
                                       class="rounded bg-black border-white/20 text-[var(--color-naranja)] focus:ring-[var(--color-dorado)] ml-2">
                                <span class="text-xs text-white">¿Termina tras las 00:00? (+{{ number_format($ajuste->nocturnidad_importe ?? 50, 0) }} €)</span>
                            </label>
                        </div>
                    </div>

                    {{-- Extras opcionales --}}
                    @if($extras->count() > 0)
                        <div>
                            <label class="block text-xs font-bold text-gray-300 uppercase mb-2">Extras opcionales</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                @foreach($extras as $extra)
                                    <label class="flex items-center gap-2.5 p-3 bg-black/70 border border-[var(--color-azul)]/30 rounded-2xl cursor-pointer hover:border-[var(--color-dorado)] transition-colors">
                                        <input type="checkbox" name="extras[]" value="{{ $extra->id }}" class="extra-checkbox rounded bg-black border-white/20 text-[var(--color-naranja)] focus:ring-[var(--color-dorado)]">
                                        <span class="text-xs text-white font-medium">
                                            {{ $extra->nombre }} <span class="text-[var(--color-dorado)] font-bold">(+{{ number_format($extra->precio, 0) }} €)</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div>
                        <label for="form-mensaje" class="block text-xs font-bold text-gray-300 uppercase mb-2">Detalles / Comentarios adicionales</label>
                        <textarea id="form-mensaje" name="mensaje" rows="3" placeholder="Horario estimado, sorpresas, canción deseada..."
                                  class="w-full bg-black border border-[var(--color-azul)]/40 rounded-3xl p-4 text-white placeholder-gray-500 focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">{{ old('mensaje') }}</textarea>
                    </div>

                    {{-- Cuadro de Desglose en Vivo --}}
                    <div id="presupuesto-live-box" class="p-6 rounded-3xl bg-[#03010E] border border-[var(--color-dorado)]/40 shadow-[0_0_30px_rgba(255,212,0,0.12)] space-y-4 transition-all">
                        <div class="flex items-center justify-between border-b border-white/10 pb-3">
                            <span class="text-xs font-bold uppercase tracking-wider text-[var(--color-dorado)] flex items-center gap-2">
                                <span class="inline-block w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Desglose en vivo de tu presupuesto
                            </span>
                            <span class="text-xs text-gray-400">Sin compromiso</span>
                        </div>

                        <div class="space-y-2 text-sm" id="presupuesto-desglose-lines">
                            {{-- Rellenado dinámicamente por JS --}}
                            <div class="flex justify-between text-xs text-gray-400 py-1">
                                <span>Calculando precio...</span>
                                <span>-- €</span>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-white/10 flex items-center justify-between">
                            <div>
                                <div class="text-xs text-gray-400 uppercase font-semibold">Total Estimado</div>
                                <div class="text-[10px] text-gray-500">IVA incluido · Con operador, plantilla y montaje</div>
                            </div>
                            <div class="text-right">
                                <div id="presupuesto-total-display" class="text-2xl md:text-3xl font-black text-gradient-warm">-- €</div>
                                <div id="presupuesto-total-note" class="text-[10px] text-[var(--color-azul-claro)] font-semibold"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 pt-2">
                        <input type="checkbox" id="consentimiento" name="consentimiento" required value="1"
                               class="mt-1 rounded bg-black border-white/20 text-[var(--color-naranja)] focus:ring-[var(--color-dorado)]">
                        <label for="consentimiento" class="text-xs text-secondary-custom">
                            He leído y acepto la <a href="{{ route('legal.privacidad') }}" target="_blank" class="text-[var(--color-dorado)] underline">política de privacidad</a> para el envío de presupuestos. *
                        </label>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="space-y-3 pt-2">
                        <button type="button" id="btn-descargar-pdf"
                                class="w-full py-4 px-6 rounded-full font-black text-base uppercase tracking-wider shadow-2xl bg-gradient-to-r from-[var(--color-dorado)] via-[var(--color-naranja)] to-[var(--color-rojo)] text-black hover:brightness-110 flex items-center justify-center gap-3 transition-all cursor-pointer">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg>
                            <span>Descargar Presupuesto en PDF</span>
                        </button>

                        <button type="submit" id="btn-enviar-reserva"
                                class="btn btn-outline w-full text-xs font-bold py-3.5 uppercase tracking-wider">
                            O Enviar Solicitud de Reserva por Email
                        </button>
                    </div>
                </form>
            </div>

            {{-- Info Lateral --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="card-glass p-8 rounded-3xl bg-[#0A0B14] border border-[var(--color-azul)]/40">
                    <h3 class="text-xl font-bold text-white mb-6">Contacto Directo</h3>

                    <div class="space-y-6">
                        <a href="https://wa.me/{{ $ajuste->whatsapp }}?text={{ rawurlencode($ajuste->whatsapp_mensaje ?? '') }}"
                           target="_blank"
                           class="flex items-center justify-center gap-3 w-full py-4 px-6 rounded-full bg-[#25D366] text-white font-bold text-base shadow-lg hover:brightness-110 transition-all">
                            <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.099 4.019 4.072-1.068z"/></svg>
                            Abrir WhatsApp
                        </a>

                        <div class="border-t border-white/10 pt-6 space-y-4 text-sm text-secondary-custom">
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Teléfono</p>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $ajuste->telefono) }}" class="text-white font-bold hover:text-[var(--color-dorado)]">
                                    {{ $ajuste->telefono }}
                                </a>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Email de reservas</p>
                                <a href="mailto:{{ $ajuste->email_contacto }}" class="text-white font-medium hover:text-[var(--color-dorado)]">
                                    {{ $ajuste->email_contacto }}
                                </a>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold">Zona de Cobertura</p>
                                <p class="text-white font-medium">{{ $ajuste->zona_cobertura }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-glass p-6 rounded-3xl bg-[#0A0B14] border border-[var(--color-dorado)]/30 text-xs text-secondary-custom space-y-2">
                    <p class="font-bold text-white uppercase text-[11px] text-[var(--color-dorado)]">Garantía Magic360:</p>
                    <p>✓ Montaje y recogida incluidos sin sorpresas.</p>
                    <p>✓ Operador presencial dedicado en todo momento.</p>
                    <p>✓ Vídeos ilimitados y descarga instantánea por QR.</p>
                    <p>✓ Presupuesto válido durante 15 días.</p>
                </div>
            </div>
        </div>
    </div>
</section>
