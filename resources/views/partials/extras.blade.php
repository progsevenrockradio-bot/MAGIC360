<section id="extras" class="py-20 bg-[#0A0B14] border-t border-[var(--color-azul)]/20 relative">
    <div class="container mx-auto px-6">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold text-[var(--color-azul-claro)] tracking-widest uppercase mb-2 block">Personalización total</span>
            <h2 class="text-3xl md:text-5xl font-black text-gradient-warm mb-4">
                Lo que incluye y extras disponibles
            </h2>
            <p class="text-secondary-custom text-base md:text-lg">
                Complementa tu alquiler de cabina 360 en Alicante con nuestros añadidos opcionales para una fiesta épica.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
            @foreach($extras as $extra)
                <div class="card-glass p-8 flex flex-col justify-between rounded-3xl border-t-2 border-t-[var(--color-dorado)]">
                    <div>
                        <div class="flex justify-between items-start mb-4 gap-2">
                            <h3 class="text-xl font-bold text-white">{{ $extra->nombre }}</h3>
                            <span class="text-lg font-black text-[var(--color-dorado)] bg-[#000000] px-3 py-1 rounded-full border border-[var(--color-dorado)]/30 shrink-0">
                                {{ $extra->precio ? '+' . number_format($extra->precio, 0) . ' €' : 'Consultar' }}
                            </span>
                        </div>
                        <p class="text-secondary-custom text-sm leading-relaxed mb-6">
                            {{ $extra->descripcion }}
                        </p>
                    </div>
                    <a href="#contacto" class="btn btn-outline text-xs font-bold py-2.5 w-full text-center uppercase">
                        Añadir al presupuesto
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
