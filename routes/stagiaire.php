<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StagiaireController as PublicStagiaireController;
use App\Http\Controllers\EvaluationController;

Route::prefix('stagiaire')->middleware(['auth:stagiaire'])->group(function () {
    Route::get('/dashboard', [PublicStagiaireController::class, 'dashboard'])->name('stagiaire.dashboard');

    // Certificats
    Route::get('/certificats', [PublicStagiaireController::class, 'certificats'])->name('stagiaire.certificats.index');
    Route::get('/certificats/{certificat}/download', [PublicStagiaireController::class, 'downloadCertificat'])->name('stagiaire.certificats.download');

    // Evaluations
    Route::get('/evaluations/{formation}', [EvaluationController::class, 'create'])->name('stagiaire.evaluations.create');
    Route::post('/evaluations/{formation}', [EvaluationController::class, 'store'])->name('stagiaire.evaluations.store');

    // Profil
    Route::get('/profil', [PublicStagiaireController::class, 'editProfile'])->name('stagiaire.profil.edit');
    Route::put('/profil', [PublicStagiaireController::class, 'updateProfile'])->name('stagiaire.profil.update');
});
