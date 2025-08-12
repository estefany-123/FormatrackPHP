<?php

use App\Http\Controllers\CodigoInventarioController;
use Illuminate\Support\Facades\Route;

Route::get('codigos',[CodigoInventarioController::class, 'index']);
Route::get('codigos/{id_codigo_inventario}',[CodigoInventarioController::class, 'show']);
Route::post('codigos',[CodigoInventarioController::class, 'store']);
Route::patch('codigos/{id_codigo_inventario}',[CodigoInventarioController::class, 'update']);