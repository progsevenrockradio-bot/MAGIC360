<section id="contacto" class="py-20 bg-[#0A0B14] border-t border-[var(--color-azul)]/20 relative">
    <div class="container mx-auto px-6 max-w-5xl">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold text-[var(--color-azul-claro)] tracking-widest uppercase mb-2 block">Reserva rápida</span>
            <h2 class="text-3xl md:text-5xl font-black text-gradient-warm mb-4">
                Reserva tu cabina 360 en {{ $ajuste->ciudad }}
            </h2>
            <p class="text-secondary-custom text-base md:text-lg">
                Cuéntanos la fecha, el lugar y cuántas horas quieres. Te contestamos el mismo día con el precio final y la disponibilidad. Si lo prefieres, escríbenos por WhatsApp.
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

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            {{-- Formulario --}}
            <div class="lg:col-span-8 card-glass p-8 md:p-10 rounded-3xl">
                <form action="{{ route('contacto.send') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Honeypot anti-spam field --}}
                    <div class="hidden" style="display: none !important;">
                        <input type="text" name="web" value="">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="form-nombre" class="block text-xs font-bold text-gray-300 uppercase mb-2">Nombre completo *</label>
                            <input type="text" id="form-nombre" name="nombre" value="{{ old('nombre') }}" required
                                   class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white placeholder-gray-500 focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                        </div>

                        <div>
                            <label for="form-telefono" class="block text-xs font-bold text-gray-300 uppercase mb-2">Teléfono *</label>
                            <input type="tel" id="form-telefono" name="telefono" value="{{ old('telefono') }}" required
                                   class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white placeholder-gray-500 focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="form-email" class="block text-xs font-bold text-gray-300 uppercase mb-2">Correo electrónico *</label>
                            <input type="email" id="form-email" name="email" value="{{ old('email') }}" required
                                   class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white placeholder-gray-500 focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                        </div>

                        <div>
                            <label for="form-fecha" class="block text-xs font-bold text-gray-300 uppercase mb-2">Fecha del evento</label>
                            <input type="date" id="form-fecha" name="fecha_evento" value="{{ old('fecha_evento') }}" min="{{ date('Y-m-d') }}"
                                   class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="form-ciudad" class="block text-xs font-bold text-gray-300 uppercase mb-2">Ciudad / Población</label>
                            <input type="text" id="form-ciudad" name="ciudad" value="{{ old('ciudad', $ajuste->ciudad) }}"
                                   class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white placeholder-gray-500 focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                        </div>

                        <div>
                            <label for="form-tipo" class="block text-xs font-bold text-gray-300 uppercase mb-2">Tipo de evento</label>
                            <select id="form-tipo" name="tipo_evento"
                                    class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm cursor-pointer">
                                <option value="Boda" {{ old('tipo_evento') == 'Boda' ? 'selected' : '' }}>Boda</option>
                                <option value="Cumpleaños / Fiesta" {{ old('tipo_evento') == 'Cumpleaños / Fiesta' ? 'selected' : '' }}>Cumpleaños / Fiesta</option>
                                <option value="Evento de Empresa" {{ old('tipo_evento') == 'Evento de Empresa' ? 'selected' : '' }}>Evento de Empresa</option>
                                <option value="Otro evento" {{ old('tipo_evento') == 'Otro evento' ? 'selected' : '' }}>Otro evento</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="form-horas" class="block text-xs font-bold text-gray-300 uppercase mb-2">Horas de servicio</label>
                            <input type="text" id="form-horas" name="horas" value="{{ old('horas') }}" placeholder="Ej: 3 horas"
                                   class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white placeholder-gray-500 focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                        </div>

                        <div>
                            <label for="form-zona" class="block text-xs font-bold text-gray-300 uppercase mb-2">Zona contratada</label>
                            <input type="text" id="form-zona" name="zona" value="{{ old('zona') }}" placeholder="Ej: Zona A"
                                   class="w-full bg-black border border-[var(--color-azul)]/40 rounded-full px-5 py-3.5 text-white placeholder-gray-500 focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="form-mensaje" class="block text-xs font-bold text-gray-300 uppercase mb-2">Detalles / Comentarios adicionales</label>
                        <textarea id="form-mensaje" name="mensaje" rows="4" placeholder="Horario estimado, sorpresas, canción deseada..."
                                  class="w-full bg-black border border-[var(--color-azul)]/40 rounded-3xl p-5 text-white placeholder-gray-500 focus:border-[var(--color-dorado)] focus:ring-1 focus:ring-[var(--color-dorado)] focus:outline-none text-sm">{{ old('mensaje') }}</textarea>
                    </div>

                    <div class="flex items-start gap-3 pt-2">
                        <input type="checkbox" id="consentimiento" name="consentimiento" required value="1"
                               class="mt-1 rounded bg-black border-white/20 text-[var(--color-naranja)] focus:ring-[var(--color-dorado)]">
                        <label for="consentimiento" class="text-xs text-secondary-custom">
                            He leído y acepto la <a href="{{ route('legal.privacidad') }}" target="_blank" class="text-[var(--color-dorado)] underline">política de privacidad</a> para el envío de presupuestos. *
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-full text-base font-bold py-4 uppercase tracking-wider shadow-xl">
                        Enviar Solicitud de Reserva
                    </button>
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
                                <p class="text-white font-medium">{{ $ajuste->ciudad }} y {{ $ajuste->zona_cobertura }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
