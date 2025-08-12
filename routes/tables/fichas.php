<?php

use App\Http\Controllers\FichasController;
use Illuminate\Support\Facades\Route;

Route::post('/fichas', [FichasController::class, 'store']);
Route::get('/fichas', [FichasController::class, 'index']);
Route::get('/fichas/{id_ficha}', [FichasController::class, 'show']);
Route::patch('/fichas/{id_ficha}', [FichasController::class, 'update']);
Route::patch('/fichas/state/{id_ficha}', [FichasController::class, 'updateState']);
