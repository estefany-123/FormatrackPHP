<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permisos extends Model
{
    use HasFactory;

    protected $table = 'permisos';
    protected $primaryKey = 'id_permiso';

    protected $fillable = [
        'permiso',
        'fk_ruta'
    ];

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'fk_ruta');
    }

    public function rolPermisos()
    {
        return $this->hasMany(RolPermiso::class, 'fk_permiso');
    }
}
