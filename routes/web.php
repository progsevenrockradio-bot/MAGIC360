<?php

use App\Http\Controllers\ContactoController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/contacto', ContactoController::class)->name('contacto.send');

// Legal pages
Route::get('/aviso-legal', [LandingController::class, 'avisoLegal'])->name('legal.aviso-legal');
Route::get('/privacidad', [LandingController::class, 'privacidad'])->name('legal.privacidad');
Route::get('/cookies', [LandingController::class, 'cookies'])->name('legal.cookies');

// SEO technical files
Route::get('/sitemap.xml', [LandingController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/robots.txt', [LandingController::class, 'robots'])->name('seo.robots');
