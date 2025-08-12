<?php

use App\Http\Controllers\InventarioController;
use Illuminate\Support\Facades\Route;

Route::get('inventarios', [InventarioController::class, 'index']);
Route::get('inventarios/{id_inventario}', [InventarioController::class, 'show']);
Route::post('inventarios', [InventarioController::class, 'store']);
Route::post('inventarios/agregarStock', [InventarioController::class, 'agregarStock']);
Route::patch('inventarios/{id_inventario}', [InventarioController::class, 'update']);
Route::delete('inventarios/state/{id_inventario}', [InventarioController::class, 'destroy']);