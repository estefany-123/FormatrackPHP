<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulos extends Model
{
    use HasFactory;

    protected $table = 'modulos';

    protected $primaryKey = 'id_modulo';

    protected $fillable = [
        'nombre',
        'descripcion',
        'href',
        'icono',
        'estado',
    ];

    public function rutas()
    {
        return $this->hasMany(Ruta::class, 'fk_modulo');
    }
}