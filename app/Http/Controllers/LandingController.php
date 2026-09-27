<?php

namespace App\Http\Controllers;

use App\Models\Ajuste;
use App\Models\Extra;
use App\Models\Media;
use App\Models\Paso;
use App\Models\Pregunta;
use App\Models\Servicio;
use App\Models\Tarifa;
use App\Models\Testimonio;
use App\Models\Zona;
use Illuminate\Http\Response;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $ajuste = Ajuste::firstOrCreate(['id' => 1]);
        $tarifas = Tarifa::where('visible', true)->orderBy('orden')->get();
        $zonas = Zona::where('visible', true)->orderBy('orden')->get();
        $extras = Extra::where('visible', true)->orderBy('orden')->get();
        $servicios = Servicio::where('visible', true)->orderBy('orden')->get();
        $pasos = Paso::orderBy('numero')->orderBy('orden')->get();
        $mediaVideos = Media::where('visible', true)->where('tipo', 'video')->orderBy('orden')->get();
        $mediaFotos = Media::where('visible', true)->where('tipo', 'imagen')->orderBy('orden')->get();
        $testimonios = Testimonio::where('visible', true)->orderBy('orden')->get();
        $preguntas = Pregunta::where('visible', true)->orderBy('orden')->get();

        // Helper function for replacing dynamic tokens in texts
        $replaceTokens = function (?string $text) use ($ajuste): string {
            if (! $text) {
                return '';
            }

            return str_replace(
                ['[CIUDAD]', '[PROVINCIA]', '[TELÉFONO]', '[ZONA]'],
                [$ajuste->ciudad, $ajuste->zona_cobertura, $ajuste->telefono, $ajuste->zona_cobertura],
                $text
            );
        };

        return view('landing', compact(
            'ajuste',
            'tarifas',
            'zonas',
            'extras',
            'servicios',
            'pasos',
            'mediaVideos',
            'mediaFotos',
            'testimonios',
            'preguntas',
            'replaceTokens'
        ));
    }

    public function avisoLegal(): View
    {
        $ajuste = Ajuste::first();

        return view('legal.aviso-legal', compact('ajuste'));
    }

    public function privacidad(): View
    {
        $ajuste = Ajuste::first();

        return view('legal.privacidad', compact('ajuste'));
    }

    public function cookies(): View
    {
        $ajuste = Ajuste::first();

        return view('legal.cookies', compact('ajuste'));
    }

    public function sitemap(): Response
    {
        $content = view('seo.sitemap')->render();

        return response($content, 200, ['Content-Type' => 'text/xml']);
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\n\nSitemap: ".url('/sitemap.xml')."\n";

        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}
