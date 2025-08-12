<?php

use App\Http\Controllers\ProgramaFormacionController;
use Illuminate\Support\Facades\Route;

Route::post('/programaF', [ProgramaFormacionController::class, 'store']);
Route::get('/programaF', [ProgramaFormacionController::class, 'index']);
Route::get('/programaF/{id_programa}', [ProgramaFormacionController::class, 'show']);
Route::patch('/programaF/{id_programa}', [ProgramaFormacionController::class, 'update']);
Route::patch('/programaF/state/{id_programa}', [ProgramaFormacionController::class, 'updateState']);
