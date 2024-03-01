<?php

use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Login
Route::post('login', [LoginController::class, 'login']);

// Curso de API Buenas prácticas
Route::middleware('auth:sanctum')->group(function () {
    require __DIR__ . '/api_v1.php';
    require __DIR__ . '/api_v2.php';

    // Posts ApiTest
    require __DIR__ . '/api_posts.php';
});
