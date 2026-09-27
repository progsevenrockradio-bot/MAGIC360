<section id="galeria" class="py-20 bg-black relative">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold text-[var(--color-azul-claro)] tracking-widest uppercase mb-2 block">Galería fotográfica</span>
            <h2 class="text-3xl md:text-5xl font-black text-gradient-warm mb-4">
                Fotos de eventos y montajes de cabina 360
            </h2>
            <p class="text-secondary-custom text-base md:text-lg">
                Así lucen nuestros equipos de plataforma 360, atrezzo e iluminación en bodas y fiestas en Alicante.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
            @foreach($mediaFotos as $foto)
                <div class="card-glass overflow-hidden group rounded-3xl border border-[var(--color-azul)]/30 aspect-[4/3] relative">
                    <img src="{{ $foto->archivo ? asset('storage/' . $foto->archivo) : $foto->url }}"
                         alt="{{ $foto->titulo ? $replaceTokens($foto->titulo) : ('Cabina 360 en evento en ' . $ajuste->ciudad) }}"
                         loading="lazy"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-6">
                        <p class="text-white text-sm font-semibold">
                            {{ $foto->titulo ? $replaceTokens($foto->titulo) : ('Cabina 360 en ' . $ajuste->ciudad) }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
