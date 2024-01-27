<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('games')->group(function () {
    Route::get('', [\App\Http\Controllers\GameController::class, 'index']);
    Route::get('find', [\App\Http\Controllers\GameController::class, "find"]);
    Route::get('{game}', [\App\Http\Controllers\GameController::class, "get"]);
    Route::post('', [\App\Http\Controllers\GameController::class, "store"]);
});

Route::prefix('pieces')->group(function () {
    Route::get('{piece}', [\App\Http\Controllers\PieceController::class, 'availableMoves']);
    Route::post('{piece}', [\App\Http\Controllers\PieceController::class, 'move'])->name('movePiece');
});
