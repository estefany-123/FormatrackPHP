<?php

use App\Http\Controllers\MunicipiosController;
use Illuminate\Support\Facades\Route;


Route::get('/municipios',[MunicipiosController::class,'index']);

Route::post('/municipios',[MunicipiosController::class,'store']);

Route::get('/municipios/{id}',[MunicipiosController::class,'show']);

Route::put('/municipios/update/{id}',[MunicipiosController::class,'update']);

Route::patch('/municipios/estado/{id}',[MunicipiosController::class,'updateState']);

