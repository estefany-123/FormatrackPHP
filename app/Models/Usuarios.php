<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    protected $table = 'usuarios';

    public $timestamps = true;

    protected $primaryKey = "id_usuario";

    public $incrementing = true;

    protected $keyType = "int";

    protected $fillable = ["documento","nombre","apellido","edad","telefono","correo","estado","cargo","password","perfil","fk_rol"];
}
