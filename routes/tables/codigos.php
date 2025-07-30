<?php

use App\Http\Controllers\CodigoInventarioController;
use Illuminate\Support\Facades\Route;

Route::get('tipos',[CodigoInventarioController::class, 'index']);
Route::get('tipos/{id_tipo}',[CodigoInventarioController::class, 'show']);
Route::post('tipos',[CodigoInventarioController::class, 'store']);
Route::patch('tipos/{id_tipo}',[CodigoInventarioController::class, 'update']);