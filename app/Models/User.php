<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    public $timestamps = true;

    protected $primaryKey = "id";

    public $incrementing = true;

    protected $keyType = "int";

    protected $fillable = ["name","email","password","password_confirmation","fk_rol"];
}
