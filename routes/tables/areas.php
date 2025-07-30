<?php

use App\Http\Controllers\AreasController;
use Illuminate\Support\Facades\Route;


Route::post('/areas', [AreasController::class, 'store']);
Route::get('/areas', [AreasController::class, 'index']);
Route::get('/areas', [AreasController::class, 'show']);
Route::put('/areas/{id_area}', [AreasController::class, 'update']);
Route::delete('/areas/state/{id_area}', [AreasController::class, 'destroy']);
