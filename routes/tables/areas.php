<?php

use App\Http\Controllers\AreasController;
use Illuminate\Support\Facades\Route;


Route::post('/areas', [AreasController::class, 'store']);
Route::get('/areas', [AreasController::class, 'index']);
Route::get('/areas/{id_area}', [AreasController::class, 'show']);
Route::patch('/areas/{id_area}', [AreasController::class, 'update']);
Route::patch('areas/state/{id_area}', [AreasController::class, 'updateState']);
