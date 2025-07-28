<?php


use App\Http\Controllers\RutasController;
use Illuminate\Support\Facades\Route;


Route::get('/rutas',[RutasController::class,'index']);

Route::post('/rutas',[RutasController::class,'store']);

Route::get('/rutas/{nombre}',[RutasController::class,'show']);

Route::put('/rutas/update/{id}',[RutasController::class,'update']);

Route::patch('/rutas/estado/{id}',[RutasController::class,'updateState']);

