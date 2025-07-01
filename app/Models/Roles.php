<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model {
    protected $table = 'roles';

    public $timestamps = true;

    protected $primaryKey = "id_rol";

    public $incrementing = true;

    protected $keyType = "int";

    protected $fillable = ["nombre","estado"];

}