<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Authentification par token pour stagiaire
    Route::get('/token-login/{token}', [AuthController::class, 'tokenLogin'])->name('token.login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
