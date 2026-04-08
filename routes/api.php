<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;

// Login
Route::post('login', [LoginController::class, 'login']);

// Curso de API Buenas prácticas
Route::middleware('auth:sanctum')->group(function () {
    require __DIR__.'/api_v1.php';
    require __DIR__.'/api_v2.php';

    // Posts ApiTest
    require __DIR__.'/api_posts.php';
});
