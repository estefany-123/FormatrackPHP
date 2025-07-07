<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $table = 'rutas';
    protected $primaryKey = 'id_ruta';

    protected $fillable = [
        'nombre',
        'descripcion',
        'href',
        'icono',
        'listed',
        'estado',
        'fk_modulo'
    ];

    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'fk_modulo');
    }

    public function permisos()
    {
        return $this->hasMany(Permisos::class, 'fk_ruta');
    }
}
