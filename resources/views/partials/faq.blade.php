<section id="faq" class="py-20 bg-black relative">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold text-[var(--color-azul-claro)] tracking-widest uppercase mb-2 block">Dudas resueltas</span>
            <h2 class="text-3xl md:text-5xl font-black text-gradient-warm mb-4">
                Preguntas frecuentes sobre el alquiler de la cabina 360
            </h2>
            <p class="text-secondary-custom text-base md:text-lg">
                Resolvemos las dudas más comunes sobre espacio, instalación, personalización y reservas en Alicante.
            </p>
        </div>

        <div class="space-y-4">
            @foreach($preguntas as $index => $pregunta)
                <div class="faq-accordion-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="faq-accordion-header">
                        <span>{{ $replaceTokens($pregunta->pregunta) }}</span>
                        <svg class="faq-accordion-icon w-5 h-5 shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="faq-accordion-content">
                        <p class="text-sm md:text-base text-secondary-custom leading-relaxed pt-2">
                            {{ $replaceTokens($pregunta->respuesta) }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
