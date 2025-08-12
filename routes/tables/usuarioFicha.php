<?php

use App\Http\Controllers\UsuarioFichaController;
use Illuminate\Support\Facades\Route;


Route::post('/areas', [UsuarioFichaController::class, 'store']);
Route::get('/areas', [UsuarioFichaController::class, 'index']);
Route::get('/areas/{id_area}', [UsuarioFichaController::class, 'show']);
Route::put('/areas/{id_area}', [UsuarioFichaController::class, 'update']);
Route::delete('/areas/state/{id_area}', [UsuarioFichaController::class, 'destroy']);
