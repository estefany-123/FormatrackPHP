<?php

use App\Http\Controllers\CaracteristicasController;
use Illuminate\Support\Facades\Route;


Route::get('/caracteristicas',[CaracteristicasController::class,'index']);

Route::post('/caracteristicas',[CaracteristicasController::class,'store']);

Route::get('/caracteristicas/{nombre}',[CaracteristicasController::class,'show']);

Route::patch('/caracteristicas/update/{id}',[CaracteristicasController::class,'update']);


