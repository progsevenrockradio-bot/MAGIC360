<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $replaceTokens($ajuste->seo_titulo) }}</title>
    <meta name="description" content="{{ $replaceTokens($ajuste->seo_descripcion) }}">
    <meta name="keywords" content="{{ $replaceTokens($ajuste->seo_palabras) }}">

    {{-- Dynamic Brand Colors from Ajustes --}}
    <style>
        :root {
            --color-negro: {{ $ajuste->color_negro ?? '#000000' }};
            --color-negro-suave: {{ $ajuste->color_negro_suave ?? '#0A0B14' }};
            --color-azul: {{ $ajuste->color_azul ?? '#024EFF' }};
            --color-azul-claro: {{ $ajuste->color_azul_claro ?? '#8F94FF' }};
            --color-dorado: {{ $ajuste->color_dorado ?? '#FFD400' }};
            --color-dorado-claro: {{ $ajuste->color_dorado_claro ?? '#FFF14A' }};
            --color-naranja: {{ $ajuste->color_naranja ?? '#FF9500' }};
            --color-rojo: {{ $ajuste->color_rojo ?? '#FF3005' }};
            --color-blanco: {{ $ajuste->color_blanco ?? '#FFFFFF' }};
            --color-gris: {{ $ajuste->color_gris ?? '#B9BCC8' }};
        }
    </style>

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="Cabina 360 para tu evento en {{ $ajuste->ciudad }} — Magic360">
    <meta property="og:description" content="{{ $replaceTokens($ajuste->seo_descripcion) }}">
    <meta property="og:image" content="{{ $ajuste->seo_imagen ? asset('storage/' . $ajuste->seo_imagen) : asset('images/logo-panoramic.svg') }}">
    <meta property="og:url" content="{{ url('/') }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $replaceTokens($ajuste->seo_titulo) }}">
    <meta name="twitter:description" content="{{ $replaceTokens($ajuste->seo_descripcion) }}">
    <meta name="twitter:image" content="{{ $ajuste->seo_imagen ? asset('storage/' . $ajuste->seo_imagen) : asset('images/logo-panoramic.svg') }}">

    <link rel="icon" type="image/svg+xml" href="{{ $ajuste->favicon ? asset('storage/' . $ajuste->favicon) : asset('images/favicon.svg') }}">

    {{-- Structured Data JSON-LD (LocalBusiness) --}}
    <script type="application/ld+json">
    {
      "{{ '@context' }}": "https://schema.org",
      "{{ '@type' }}": "LocalBusiness",
      "name": "{{ $ajuste->nombre_marca }}",
      "image": "{{ $ajuste->logo ? asset('storage/' . $ajuste->logo) : asset('images/logo-panoramic.svg') }}",
      "telephone": "{{ $ajuste->telefono }}",
      "email": "{{ $ajuste->email_contacto }}",
      "url": "{{ url('/') }}",
      "priceRange": "€€",
      "address": {
        "{{ '@type' }}": "PostalAddress",
        "addressLocality": "{{ $ajuste->ciudad }}",
        "addressRegion": "{{ $ajuste->zona_cobertura }}",
        "addressCountry": "ES"
      },
      "areaServed": {
        "{{ '@type' }}": "AdministrativeArea",
        "name": "{{ $ajuste->zona_cobertura }}"
      },
      "sameAs": [
        "{{ $ajuste->instagram }}",
        "{{ $ajuste->facebook }}"
      ]
    }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#000000] text-[#FFFFFF] font-sans antialiased selection:bg-[#024EFF] selection:text-white">

    {{-- Header / Menú fijo --}}
    <header class="header py-4">
        <div class="container mx-auto px-6 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 text-2xl font-black text-white tracking-wider group">
                <img src="{{ $ajuste->logo ? asset('storage/' . $ajuste->logo) : asset('images/logo-round.svg') }}" alt="Magic360 Logo" class="h-12 w-auto object-contain transition-transform group-hover:scale-105">
                <span class="font-extrabold text-white text-xl tracking-tight hidden sm:inline-block">MAGIC<span class="text-gradient-warm">360</span></span>
            </a>

            <nav id="nav-menu" class="hidden lg:flex items-center gap-8 text-sm font-semibold">
                <a href="#precios" class="nav-link">Precios</a>
                <a href="#que-es" class="nav-link">Qué es</a>
                <a href="#como-funciona" class="nav-link">Cómo funciona</a>
                <a href="#videos" class="nav-link">Vídeos</a>
                <a href="#galeria" class="nav-link">Fotos</a>
                <a href="#opiniones" class="nav-link">Opiniones</a>
                <a href="#faq" class="nav-link">FAQ</a>
                <a href="#contacto" class="nav-link">Contacto</a>
            </nav>

            <div class="flex items-center gap-4">
                <a href="#precios" class="btn btn-primary text-xs uppercase tracking-wider py-2.5 px-6 hidden sm:inline-flex">
                    Ver precios
                </a>
                <button id="nav-toggle-btn" class="lg:hidden p-2 text-white hover:text-[var(--color-dorado)] focus:outline-none" aria-label="Abrir menú">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
    </header>

    <main>
        {{-- Section 1: Hero --}}
        @include('partials.hero')

        {{-- Section 2: Franja de contacto --}}
        @include('partials.franja-contacto')

        {{-- Section 3: PRECIOS (Justo debajo del hero) --}}
        @include('partials.precios')

        {{-- Section 4: Qué es --}}
        @include('partials.que-es')

        {{-- Section 5: Cómo funciona --}}
        @include('partials.como-funciona')

        {{-- Section 6: Vídeos --}}
        @include('partials.videos')

        {{-- Section 7: Fotos / Galería --}}
        @include('partials.galeria')

        {{-- Section 8: Extras --}}
        @include('partials.extras')

        {{-- Section 9: Radio (opcional) --}}
        @include('partials.radio')

        {{-- Section 10: Opiniones --}}
        @include('partials.opiniones')

        {{-- Section 11: FAQ --}}
        @include('partials.faq')

        {{-- Section 12: Contacto --}}
        @include('partials.contacto')
    </main>

    {{-- Pie de página --}}
    @include('partials.pie')

    {{-- Botón WhatsApp flotante --}}
    <a href="https://wa.me/{{ $ajuste->whatsapp }}?text={{ rawurlencode($ajuste->whatsapp_mensaje ?? '') }}"
       target="_blank"
       class="whatsapp-float"
       aria-label="Contactar por WhatsApp">
        <svg class="w-8 h-8 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.099 4.019 4.072-1.068z"/></svg>
    </a>

    {{-- Video Lightbox Modal --}}
    <div id="video-lightbox" class="modal-lightbox">
        <button id="close-lightbox" class="absolute top-6 right-6 text-white hover:text-[var(--color-dorado)] text-4xl font-bold p-3 focus:outline-none" aria-label="Cerrar vídeo">
            &times;
        </button>
        <div class="max-w-4xl w-[90%] max-h-[85vh] aspect-video rounded-3xl overflow-hidden shadow-2xl relative bg-black flex items-center justify-center border border-[var(--color-azul)]">
            <iframe id="video-lightbox-iframe" class="w-full h-full hidden" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            <video id="video-lightbox-video" class="w-full h-full hidden" controls preload="none"></video>
        </div>
    </div>

</body>
</html>
