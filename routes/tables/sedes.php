<?php

use App\Http\Controllers\SedesController;
use Illuminate\Support\Facades\Route;


Route::post('/sedes', [SedesController::class, 'store']);
Route::get('/sedes', [SedesController::class, 'show']);
Route::get('/sedes', [SedesController::class, 'index']);
Route::put('/sedes/{id_sede}', [SedesController::class, 'update']);
Route::delete('/sedes/state/{id_sede}', [SedesController::class, 'destroy']);
