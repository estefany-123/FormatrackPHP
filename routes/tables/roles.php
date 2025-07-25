<?php

use App\Http\Controllers\RolesController;
use Illuminate\Support\Facades\Route;
use App\Models\Roles;

Route::get('roles',[RolesController::class, 'index']);
Route::get('roles/{id_rol}',[RolesController::class, 'show']);
Route::post('roles',[RolesController::class, 'store']);
Route::patch('roles/{id_rol}',[RolesController::class, 'update']);
Route::delete('roles/state/{id_rol}',[RolesController::class, 'destroy']);
