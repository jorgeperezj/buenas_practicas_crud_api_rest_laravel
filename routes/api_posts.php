<?php

use App\Http\Controllers\ApiCrud\V1\PostController as PostV1;
use App\Http\Controllers\ApiCrud\V2\PostController as PostV2;

// V1
Route::apiResource('V1/posts', PostV1::class)
    ->only(['index', 'show', 'destroy'])
    ->middleware('auth:sanctum');

// V2
Route::apiResource('V2/posts', PostV2::class)
    ->only(['index', 'show', 'store'])
    ->middleware('auth:sanctum');
