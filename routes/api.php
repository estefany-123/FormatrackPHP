<?php

use Illuminate\Support\Facades\Route;
use App\Models\Usuarios;

Route::get('/usuarios', function () {
    return Usuarios::all();
});