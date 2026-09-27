<section id="videos" class="py-20 bg-[#0A0B14] border-t border-[var(--color-azul)]/20 relative">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold text-[var(--color-azul-claro)] tracking-widest uppercase mb-2 block">Demostración en vivo</span>
            <h2 class="text-3xl md:text-5xl font-black text-gradient-warm mb-4">
                Cabina 360 en acción: vídeos de eventos reales
            </h2>
            <p class="text-secondary-custom text-base md:text-lg">
                Haz clic en cualquier vídeo para reproducirlo a pantalla completa y comprobar los efectos visuales.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
            @foreach($mediaVideos as $video)
                <div class="card-glass overflow-hidden group cursor-pointer video-trigger relative rounded-3xl border border-[var(--color-azul)]/30 aspect-[9/16]"
                     data-video-url="{{ $video->archivo ? asset('storage/' . $video->archivo) : $video->url }}">

                    @if($video->miniatura)
                        <img src="{{ asset('storage/' . $video->miniatura) }}"
                             alt="{{ $video->titulo ?? 'Vídeo cabina 360' }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-black flex items-center justify-center p-4 text-center">
                            <span class="text-xs text-[var(--color-gris)] font-medium">{{ $video->titulo ?? 'Ver vídeo 360' }}</span>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors flex flex-col items-center justify-center p-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-r from-[var(--color-dorado-claro)] via-[var(--color-naranja)] to-[var(--color-rojo)] text-black flex items-center justify-center shadow-[0_0_20px_rgba(255,149,0,0.6)] group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 fill-current ml-1" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                        </div>
                        @if($video->titulo)
                            <p class="text-white text-xs font-semibold mt-4 text-center bg-black/80 px-3 py-1 rounded-full backdrop-blur-md border border-white/10">
                                {{ $video->titulo }}
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
