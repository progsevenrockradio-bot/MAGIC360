<section id="precios" class="py-20 bg-black relative overflow-hidden">
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-3xl md:text-5xl font-black text-gradient-warm mb-4">
                {{ $ajuste->tarifas_titulo ?? 'Precios de alquiler de cabina 360' }}
            </h2>
            <p class="text-secondary-custom text-base md:text-lg">
                Elige las horas de servicio y selecciona tu zona para ver el importe final al instante sin sorpresas.
            </p>
        </div>

        {{-- Selector de Zona --}}
        <div class="max-w-xl mx-auto mb-14 bg-[#0A0B14] border border-[var(--color-azul)]/40 p-6 rounded-3xl shadow-[0_0_20px_rgba(2,78,255,0.2)]">
            <label for="zone-select" class="block text-sm font-bold text-white mb-3 text-center uppercase tracking-wider">
                 Selecciona la zona de tu evento para recalcular precios:
            </label>
            <select id="zone-select" class="w-full bg-black border border-[var(--color-azul)] text-white rounded-full px-6 py-4 font-semibold text-base focus:ring-2 focus:ring-[var(--color-dorado)] focus:outline-none cursor-pointer">
                @foreach($zonas as $index => $zona)
                    <option value="{{ $zona->nombre }}"
                            data-recargo="{{ $zona->recargo }}"
                            data-consultar="{{ $zona->a_consultar ? '1' : '0' }}"
                            {{ $index === 0 ? 'selected' : '' }}>
                        {{ $zona->nombre }} — {{ $zona->descripcion }} ({{ $zona->a_consultar ? 'A consultar' : ($zona->recargo > 0 ? '+' . number_format($zona->recargo, 0) . ' €' : 'Sin recargo') }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tarjetas de Precios --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-7xl mx-auto items-stretch">
            @foreach($tarifas as $tarifa)
                <div class="price-card p-8 flex flex-col justify-between relative rounded-3xl transition-all duration-300 {{ $tarifa->destacada ? 'card-featured scale-105 z-20' : 'card-glass' }}"
                     data-base-price="{{ $tarifa->precio }}">

                    @if($tarifa->destacada)
                        <div class="absolute -top-4 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full bg-gradient-to-r from-[var(--color-dorado)] via-[var(--color-naranja)] to-[var(--color-rojo)] text-black font-extrabold text-xs uppercase tracking-wider shadow-lg">
                            ⭐ La más pedida
                        </div>
                    @endif

                    <div>
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold text-white mb-2">{{ $tarifa->nombre }}</h3>
                            <div class="text-4xl font-extrabold price-display my-3 tracking-tight">
                                <span class="price-value">
                                    @if($tarifa->precio)
                                        {{ number_format($tarifa->precio, 0) }} €
                                    @else
                                        Consultar precio
                                    @endif
                                </span>
                            </div>
                            <div class="surcharge-display text-xs text-[var(--color-azul-claro)] font-semibold h-4">
                                {{-- Updated dynamically via JS --}}
                            </div>
                        </div>

                        {{-- Lista de lo que incluye --}}
                        @if(!empty($tarifa->incluye))
                            <ul class="space-y-3 mb-8 text-sm text-secondary-custom">
                                @foreach($tarifa->incluye as $item)
                                    <li class="flex items-start gap-2">
                                        <svg class="w-5 h-5 text-[var(--color-dorado)] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                        <span>{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <a href="#contacto"
                       class="btn btn-reservar w-full text-center text-sm font-bold py-3.5 {{ $tarifa->destacada ? 'btn-primary uppercase' : 'btn-outline uppercase' }}"
                       data-tarifa-nombre="{{ $tarifa->nombre }}">
                        Reservar esta tarifa
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Nota informativa sobre IVA y nocturnidad --}}
        @if($ajuste->tarifas_nota)
            <div class="mt-14 text-center max-w-3xl mx-auto text-xs md:text-sm text-secondary-custom bg-[#0A0B14] border border-[var(--color-azul)]/30 p-5 rounded-2xl">
                {{ $replaceTokens($ajuste->tarifas_nota) }}
            </div>
        @endif
    </div>
</section>
