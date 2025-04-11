<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificatController;

// Vérification des certificats
Route::get('/certificat/verify/{id}', [CertificatController::class, 'verify'])->name('certificat.verify');

// Autres routes publiques si nécessaire...
