<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FormationController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\StagiaireController;
use App\Http\Controllers\EvaluationController;

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Formations
    Route::resource('formations', FormationController::class)->except(['show']);

    // Sessions
    Route::prefix('formations/{formation}/sessions')->group(function() {
        Route::get('/', [SessionController::class, 'index'])->name('admin.formations.sessions.index');
        // ... toutes les autres routes sessions ...
    });

    // Stagiaires
    Route::resource('stagiaires', StagiaireController::class);
    Route::post('stagiaires/import', [StagiaireController::class, 'import'])->name('stagiaires.import');

    // Documents
    Route::prefix('documents')->group(function() {
        // ... routes documents ...
    });

    // Evaluations
    Route::get('evaluations', [EvaluationController::class, 'index'])->name('admin.evaluations.index');
    // ... autres routes évaluations ...
});
