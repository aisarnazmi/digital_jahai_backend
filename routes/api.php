<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LibraryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/user', 'user');
        Route::get('/logout', 'logout');
    });
});

Route::get('library/translate', [LibraryController::class, 'translate']);
Route::apiResource('library', LibraryController::class)->only(['index', 'store']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('library', LibraryController::class)->only(['update', 'destroy']);
});
