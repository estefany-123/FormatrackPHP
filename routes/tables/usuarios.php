<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UsuarioPermisoController;

Route::get('/usuarios/perfil', [UsersController::class, 'perfilInfo']);

Route::post('/usuarios/perfil/update', [UsersController::class, 'updateFoto']); 

Route::get('/usuarios',[UsersController::class,'index']);

Route::get('/usuarios/{nombre}',[UsersController::class,'show']);

Route::patch('/usuarios/perfil',[UsersController::class,'updateperfil']);

Route::put('/usuarios/update/{id}',[UsersController::class,'update']);

Route::patch('/usuarios/estado/{id}',[UsersController::class,'updateState']);

Route::post('/usuarios/massive',[UsersController::class,'massiveUpload']);

Route::get('/permisos/refetch', [UsuarioPermisoController::class, 'refetch']);
