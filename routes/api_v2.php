<?php

use App\Http\Controllers\Api\V2\RecipeController;

// Curso de API Buenas prácticas
Route::prefix('V2')->group(function () {
    Route::get('recipes', [RecipeController::class, 'index']);
});
