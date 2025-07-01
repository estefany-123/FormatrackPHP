<?php

use Illuminate\Support\Facades\Route;
use App\Models\Roles;

Route::get('/roles', function () {
    return Roles::all();
});