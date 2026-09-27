<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso Legal · {{ $ajuste->nombre_marca ?? 'Magic360' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#03010E] text-gray-200 py-16">
    <div class="container mx-auto px-6 max-w-4xl">
        <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 text-primary hover:underline mb-8 text-sm">
            ← Volver a Magic360
        </a>
        <div class="card-glass p-8 md:p-12 prose prose-invert max-w-none">
            {!! $ajuste->aviso_legal !!}
        </div>
    </div>
</body>
</html>
