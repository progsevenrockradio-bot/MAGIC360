<section id="que-es" class="py-20 bg-[#0A0B14] border-y border-[var(--color-azul)]/20 relative">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold text-[var(--color-azul-claro)] tracking-widest uppercase mb-2 block">Experiencia audiovisual</span>
            <h2 class="text-3xl md:text-5xl font-black text-gradient-warm mb-4">
                ¿Qué es una cabina 360 y por qué triunfa en los eventos?
            </h2>
            <p class="text-secondary-custom text-base md:text-lg">
                {{ $ajuste->texto_que_es }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($servicios as $servicio)
                <div class="card-glass p-8 text-center flex flex-col items-center rounded-3xl">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-[var(--color-azul)] to-[var(--color-azul-claro)] flex items-center justify-center text-white mb-6 shadow-[0_0_15px_rgba(2,78,255,0.4)]">
                        @if($servicio->icono === 'video-camera')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        @elseif($servicio->icono === 'paint-brush')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
                        @elseif($servicio->icono === 'qr-code')
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        @else
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        @endif
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">{{ $servicio->titulo }}</h3>
                    <p class="text-secondary-custom text-sm leading-relaxed">{{ $servicio->descripcion }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
