<div class="bg-[#0A0B14] border-y border-[var(--color-azul)]/20 py-6">
    <div class="container mx-auto px-6 flex flex-wrap items-center justify-between gap-6 text-center md:text-left">
        <div class="flex items-center gap-3 mx-auto md:mx-0">
            <span class="p-3 rounded-full bg-[var(--color-azul)]/10 text-[var(--color-azul-claro)] border border-[var(--color-azul)]/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h32a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5zm0 6a2 2 0 012-2h14a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2zm0 6a2 2 0 012-2h14a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2z"></path></svg>
            </span>
            <div>
                <p class="text-xs text-[var(--color-gris)] uppercase tracking-wider font-semibold">Atención directa</p>
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $ajuste->telefono) }}" class="text-lg font-bold text-white hover:text-[var(--color-dorado)] transition-colors">
                    {{ $ajuste->telefono }}
                </a>
            </div>
        </div>

        <div class="flex items-center gap-4 mx-auto md:mx-0">
            <a href="https://wa.me/{{ $ajuste->whatsapp }}?text={{ rawurlencode($ajuste->whatsapp_mensaje ?? '') }}"
               target="_blank"
               class="flex items-center gap-2 px-4 py-2 rounded-full bg-[#25D366]/20 border border-[#25D366]/40 text-[#25D366] hover:bg-[#25D366] hover:text-white transition-all text-sm font-semibold">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.099 4.019 4.072-1.068z"/></svg>
                WhatsApp Directo
            </a>
            <span class="hidden lg:inline text-gray-500">•</span>
            <a href="mailto:{{ $ajuste->email_contacto }}" class="hidden lg:inline text-sm text-[var(--color-gris)] hover:text-white transition-colors">
                {{ $ajuste->email_contacto }}
            </a>
        </div>
    </div>
</div>
