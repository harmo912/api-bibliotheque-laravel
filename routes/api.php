<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\EmpruntController;

// Routes publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/livres', [LivreController::class, 'index']);
Route::get('/livres/{id}', [LivreController::class, 'show']);

// Routes protégées via Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Actions Admin pour les livres
    Route::post('/livres', [LivreController::class, 'store']);
    Route::put('/livres/{id}', [LivreController::class, 'update']);
    Route::delete('/livres/{id}', [LivreController::class, 'destroy']);

    // --- Nouvelles Routes pour les Emprunts ---
    Route::post('/emprunts', [EmpruntController::class, 'emprunter']);       // Emprunter un livre
    Route::post('/emprunts/{id}/retour', [EmpruntController::class, 'retourner']); // Rendre un livre
    Route::get('/emprunts/historique', [EmpruntController::class, 'historique']); // Voir l'historique
});