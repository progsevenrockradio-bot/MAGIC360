<section class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden bg-black">
    {{-- Background Glow & Animated Vector --}}
    <div class="absolute left-1/2 top-0 -translate-y-1/2 -translate-x-1/2 w-96 h-96 md:w-[650px] md:h-[650px] -z-20 blur-3xl rounded-full"
         style="background: radial-gradient(circle, rgba(2, 78, 255, 0.35) 0%, rgba(255, 48, 5, 0.2) 45%, transparent 70%);">
    </div>

    <div class="container mx-auto px-6 relative z-10 text-center">
        <div class="max-w-4xl mx-auto">
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 mb-6 rounded-full bg-[#0A0B14] border border-[var(--color-azul)]/30 backdrop-blur-md">
                <span class="w-2.5 h-2.5 rounded-full bg-[var(--color-naranja)] animate-ping"></span>
                <span class="text-xs md:text-sm font-semibold text-[var(--color-blanco)]">
                     Cabina 360º para Bodas, Cumpleaños y Eventos en Alicante
                </span>
            </div>

            {{-- H1 Headline --}}
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-black tracking-tight text-gradient-warm mb-6 leading-tight">
                {!! nl2br(e($replaceTokens($ajuste->hero_titulo ?? 'Tu evento, en 360º'))) !!}
            </h1>

            {{-- Subtitle --}}
            <p class="text-lg md:text-xl text-secondary-custom mb-10 max-w-2xl mx-auto leading-relaxed">
                {{ $replaceTokens($ajuste->hero_subtitulo) }}
            </p>

            {{-- Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                <a href="#precios" class="btn btn-primary w-full sm:w-auto text-base uppercase tracking-wider">
                    Ver Precios y Disponibilidad
                </a>
                <a href="#contacto" class="btn btn-outline w-full sm:w-auto text-base uppercase tracking-wider">
                    Pedir Presupuesto
                </a>
            </div>
        </div>

        {{-- Video / Image Showcase Container --}}
        <div class="max-w-5xl mx-auto mt-6 rounded-3xl overflow-hidden border border-[var(--color-azul)]/30 shadow-[0_0_40px_rgba(2,78,255,0.2)] bg-[#0A0B14] relative group">
            @if(!empty($ajuste->hero_video) || !empty($ajuste->hero_video_url))
                <video class="w-full aspect-video object-cover"
                       autoplay loop muted playsinline
                       poster="{{ $ajuste->hero_imagen ? asset('storage/' . $ajuste->hero_imagen) : 'https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=1200&auto=format&fit=crop&q=80' }}">
                    <source src="{{ $ajuste->hero_video ? asset('storage/' . $ajuste->hero_video) : $ajuste->hero_video_url }}" type="video/mp4">
                    Tu navegador no soporta el reproductor de vídeo.
                </video>
            @elseif(!empty($ajuste->hero_imagen))
                <img src="{{ asset('storage/' . $ajuste->hero_imagen) }}"
                     alt="Cabina 360 en evento en {{ $ajuste->ciudad }}"
                     class="w-full aspect-video object-cover">
            @else
                <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?w=1200&auto=format&fit=crop&q=80"
                     alt="Cabina 360 para eventos"
                     class="w-full aspect-video object-cover">
            @endif
        </div>
    </div>
</section>
