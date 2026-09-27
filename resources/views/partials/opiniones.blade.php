<section id="opiniones" class="py-20 bg-[#0A0B14] border-t border-[var(--color-azul)]/20 relative">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold text-[var(--color-azul-claro)] tracking-widest uppercase mb-2 block">Experiencias reales</span>
            <h2 class="text-3xl md:text-5xl font-black text-gradient-warm mb-4">
                Qué dicen quienes ya la han alquilado
            </h2>
            <p class="text-secondary-custom text-base md:text-lg">
                Reseñas verificadas de clientes que contaron con Magic360 para su boda, cumpleaños o evento en Alicante.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($testimonios as $testimonio)
                <div class="card-glass p-8 flex flex-col justify-between relative rounded-3xl">
                    <div>
                        {{-- Estrellas --}}
                        <div class="flex items-center gap-1 text-[var(--color-dorado)] mb-4">
                            @for($i = 0; $i < $testimonio->estrellas; $i++)
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>

                        <p class="text-secondary-custom text-sm leading-relaxed italic mb-6">
                            "{{ $testimonio->texto }}"
                        </p>
                    </div>

                    <div class="border-t border-white/10 pt-4">
                        <h4 class="text-white font-bold text-base">{{ $testimonio->nombre }}</h4>
                        <p class="text-xs text-[var(--color-dorado)] font-semibold">{{ $replaceTokens($testimonio->tipo_evento) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
