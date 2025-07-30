<?php

use App\Http\Controllers\SitiosController;
use Illuminate\Support\Facades\Route;


Route::post('/sitios', [SitiosController::class, 'store']);
Route::get('/sitios', [SitiosController::class, 'index']);
Route::get('/sitios', [SitiosController::class, 'show']);
Route::put('/sitios/{id_sitio}', [SitiosController::class, 'update']);
Route::delete('/sitios/state/{id_sitio}', [SitiosController::class, 'destroy']);
