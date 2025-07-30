<?php

use App\Http\Controllers\FichasController;
use Illuminate\Support\Facades\Route;

Route::post('/fichas', [FichasController::class, 'store']);
Route::get('/fichas', [FichasController::class, 'index']);
Route::get('/fichas', [FichasController::class, 'show']);
Route::put('/fichas/{id_ficha}', [FichasController::class, 'update']);
Route::delete('/fichas/state/{id_ficha}', [FichasController::class, 'destroy']);
