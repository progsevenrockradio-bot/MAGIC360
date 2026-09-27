<section id="como-funciona" class="py-20 bg-black relative">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold text-[var(--color-azul-claro)] tracking-widest uppercase mb-2 block">Proceso sencillo</span>
            <h2 class="text-3xl md:text-5xl font-black text-gradient-warm mb-4">
                Cómo funciona (en 3 pasos)
            </h2>
            <p class="text-secondary-custom text-base md:text-lg">
                {{ $ajuste->texto_como_funciona }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto relative">
            @foreach($pasos as $paso)
                <div class="card-glass p-8 relative flex flex-col items-start border-l-4 border-l-[var(--color-dorado)] rounded-3xl">
                    <div class="absolute top-6 right-6 text-5xl font-black text-white/10 select-none">
                        0{{ $paso->numero }}
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-[var(--color-azul)]/20 text-[var(--color-dorado)] flex items-center justify-center font-extrabold text-lg mb-6 border border-[var(--color-azul)]/40">
                        {{ $paso->numero }}
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ $replaceTokens($paso->titulo) }}</h3>
                    <p class="text-secondary-custom text-sm leading-relaxed">{{ $replaceTokens($paso->descripcion) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
