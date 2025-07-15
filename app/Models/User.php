<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'users';

    public $timestamps = true;

    protected $primaryKey = "id";

    public $incrementing = true;

    protected $keyType = "int";

    protected $fillable = ["name", "email", "password", "fk_rol"];

    public function rol()
{
    return $this->belongsTo(Roles::class, 'fk_rol', 'id_rol');
}


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


}
