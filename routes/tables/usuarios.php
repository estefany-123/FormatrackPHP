<?php

use Illuminate\Support\Facades\Route;
use App\Models\Usuarios;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

Route::get('/usuarios', function () {

    $usuarios = Usuarios::all()->toArray();

    $usuarios = array_map(function ($usuario) {
        $usuario["idUsuario"] = $usuario["id_usuario"];
        unset($usuario["id_usuario"]);
        return $usuario;
    }, $usuarios);

    return $usuarios;
});