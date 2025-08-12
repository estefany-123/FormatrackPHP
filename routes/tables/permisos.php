<?php

use App\Http\Controllers\PermisosController;
use Illuminate\Support\Facades\Route;


Route::post('/permisos', [PermisosController::class, 'store']);
Route::get('/permisos', [PermisosController::class, 'index']);
Route::get('/permisos/{id_permiso}', [PermisosController::class, 'show']);
Route::put('/permisos/{id_permiso}', [PermisosController::class, 'update']);
