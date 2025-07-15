<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

Route::get('/usuarios',[UsersController::class,'index']);

Route::get('/usuarios/{nombre}',[UsersController::class,'show']);

Route::get('/usuarios/perfil/{id}',[UsersController::class,'perfil']);

Route::patch('/usuarios/perfil/{id}',[UsersController::class,'updateperfil']);

Route::put('/usuarios/update/{id}',[UsersController::class,'update']);

Route::patch('/usuarios/estado/{id}',[UsersController::class,'updateState']);

Route::patch('/usuarios/updatefoto/{id}', [UsersController::class, 'up']);//no sirve aun

