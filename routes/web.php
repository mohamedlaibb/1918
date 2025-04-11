<?php

use Illuminate\Support\Facades\Route;

// Route publique d'accueil
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentification (gardez-la dans web.php)
require __DIR__.'/auth.php';

// Routes Admin
require __DIR__.'/admin.php';

// Routes Stagiaire
require __DIR__.'/stagiaire.php';

// Routes Publiques (certificats, etc.)
require __DIR__.'/public.php';
