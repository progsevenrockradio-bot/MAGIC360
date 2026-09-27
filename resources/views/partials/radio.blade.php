@if($ajuste->radio_activa)
<section id="radio" class="py-16 bg-[#03010E] border-t border-white/10 relative">
    <div class="container mx-auto px-6 max-w-4xl">
        <div class="card-glass p-8 md:p-10 flex flex-col md:flex-row items-center justify-between gap-8 bg-gradient-to-r from-[#14162B] to-[#0B0C17]">
            <div class="flex items-center gap-6">
                <div class="w-16 h-16 rounded-full bg-primary/20 text-primary flex items-center justify-center shrink-0 animate-pulse">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path></svg>
                </div>
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-red-500/20 text-red-400 text-xs font-bold uppercase tracking-wider mb-2">● En Directo</span>
                    <h3 class="text-2xl font-bold text-white mb-1">{{ $ajuste->radio_nombre ?? 'Radio Magic360' }}</h3>
                    <p class="text-xs text-gray-400">{{ $ajuste->radio_horario ?? 'Emisión en vivo 24/7' }}</p>
                </div>
            </div>

            <div class="w-full md:w-auto">
                <audio controls class="w-full md:w-80 rounded-full border border-white/20">
                    <source src="{{ $ajuste->radio_url }}" type="audio/mpeg">
                    Tu navegador no soporta el reproductor de audio.
                </audio>
            </div>
        </div>
    </div>
</section>
@endif
