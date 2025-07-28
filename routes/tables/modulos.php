<?php


use App\Http\Controllers\ModulosController;
use Illuminate\Support\Facades\Route;


Route::get('/modulos',[ModulosController::class,'index']);

Route::post('/modulos',[ModulosController::class,'store']);

Route::get('/modulos/{id}',[ModulosController::class,'show']);

Route::put('/modulos/update/{id}',[ModulosController::class,'update']);

Route::patch('/modulos/estado/{id}',[ModulosController::class,'updateState']);

