<?php

use App\Http\Controllers\SedesController;
use Illuminate\Support\Facades\Route;


Route::post('/sedes', [SedesController::class, 'store']);
Route::get('/sedes/{id_sede}', [SedesController::class, 'show']);
Route::get('/sedes', [SedesController::class, 'index']);
Route::patch('/sedes/{id_sede}', [SedesController::class, 'update']);
Route::patch('/sedes/state/{id_sede}', [SedesController::class, 'updateState']);
