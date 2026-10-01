<footer class="bg-black border-t border-[var(--color-azul)]/20 pt-16 pb-12 text-sm text-[var(--color-gris)]">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-12">
            <div>
                <a href="{{ route('landing') }}" class="flex items-center gap-3 text-2xl font-black text-white tracking-wider group">
                    <img src="{{ $ajuste->logo ? asset('storage/' . $ajuste->logo) : asset('images/logo-round.svg') }}" alt="Magic360 Logo" class="h-10 w-auto object-contain">
                    <span class="font-extrabold text-white text-xl tracking-tight">MAGIC<span class="text-gradient-warm">360</span></span>
                </a>
                <p class="text-xs text-[var(--color-gris)] mt-2">
                    {{ $ajuste->eslogan }}
                </p>
            </div>

            {{-- Redes sociales --}}
            <div class="flex items-center gap-4">
                @if(!empty(trim($ajuste->instagram ?? '')))
                    <a href="{{ $ajuste->instagram }}" target="_blank" aria-label="Instagram" class="w-10 h-10 rounded-full bg-[#0A0B14] border border-[var(--color-azul)]/30 flex items-center justify-center text-white hover:border-[var(--color-dorado)] hover:text-[var(--color-dorado)] transition-all shadow-md">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </a>
                @endif
                @if(!empty(trim($ajuste->facebook ?? '')))
                    <a href="{{ $ajuste->facebook }}" target="_blank" aria-label="Facebook" class="w-10 h-10 rounded-full bg-[#0A0B14] border border-[var(--color-azul)]/30 flex items-center justify-center text-white hover:border-[var(--color-dorado)] hover:text-[var(--color-dorado)] transition-all shadow-md">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.592 0 9 1.583 9 4.615V8z"/></svg>
                    </a>
                @endif
                @if(!empty(trim($ajuste->tiktok ?? '')))
                    <a href="{{ $ajuste->tiktok }}" target="_blank" aria-label="TikTok" class="w-10 h-10 rounded-full bg-[#0A0B14] border border-[var(--color-azul)]/30 flex items-center justify-center text-white hover:border-[var(--color-dorado)] hover:text-[var(--color-dorado)] transition-all shadow-md">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.97v7.5c0 1.52-.33 3.06-1.12 4.34-1.28 2.06-3.61 3.33-6.04 3.35-2.43.02-4.81-1.19-6.14-3.21-1.33-2.02-1.57-4.6-.64-6.85.93-2.25 3.09-3.83 5.51-4.07.72-.07 1.45-.03 2.16.12v4.13c-.48-.15-.99-.21-1.49-.16-1.11.1-2.12.72-2.61 1.71-.49.99-.43 2.19.16 3.12.59.93 1.64 1.48 2.74 1.44 1.1-.04 2.1-.64 2.53-1.66.21-.49.32-1.02.32-1.55V.02z"/></svg>
                    </a>
                @endif
                @if(!empty(trim($ajuste->youtube ?? '')))
                    <a href="{{ $ajuste->youtube }}" target="_blank" aria-label="YouTube" class="w-10 h-10 rounded-full bg-[#0A0B14] border border-[var(--color-azul)]/30 flex items-center justify-center text-white hover:border-[var(--color-dorado)] hover:text-[var(--color-dorado)] transition-all shadow-md">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                @endif
            </div>
        </div>

        {{-- Legal links & copyright --}}
        <div class="border-t border-[var(--color-azul)]/20 pt-8 flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-[var(--color-gris)]">
            <p>{{ $replaceTokens($ajuste->texto_pie) }}</p>

            <div class="flex items-center gap-6">
                <a href="{{ route('legal.aviso-legal') }}" class="hover:text-[var(--color-dorado)] transition-colors">Aviso Legal</a>
                <a href="{{ route('legal.privacidad') }}" class="hover:text-[var(--color-dorado)] transition-colors">Política de Privacidad</a>
                <a href="{{ route('legal.cookies') }}" class="hover:text-[var(--color-dorado)] transition-colors">Política de Cookies</a>
            </div>
        </div>
    </div>
</footer>
