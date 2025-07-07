<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolPermiso extends Model
{
    use HasFactory;

    protected $table = 'rol_permiso';
    protected $primaryKey = 'id_rol_permiso';

    protected $fillable = [
        'estado',
        'fk_rol',
        'fk_permiso'
    ];

    public function rol()
    {
        return $this->belongsTo(Roles::class, 'fk_rol');
    }

    public function permiso()
    {
        return $this->belongsTo(Permisos::class, 'fk_permiso');
    }
}
