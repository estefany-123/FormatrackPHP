<?php

use App\Http\Controllers\ProgramaFormacionController;
use Illuminate\Support\Facades\Route;

Route::post('/programaF', [ProgramaFormacionController::class, 'store']);
Route::get('/programaF', [ProgramaFormacionController::class, 'index']);
Route::get('/programaF', [ProgramaFormacionController::class, 'show']);
Route::put('/programaF/{id_programa}', [ProgramaFormacionController::class, 'update']);
Route::delete('/programaF/state/{id_programa}', [ProgramaFormacionController::class, 'destroy']);
