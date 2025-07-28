<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutas extends Model
{
    use HasFactory;

    protected $table = 'rutas';
    protected $primaryKey = 'id_ruta';

    protected $fillable = [
        'nombre',
        'href',
        'icono',
        'listed',
        'estado',
        'fk_modulo'
    ];

    public function modulo()
    {
        return $this->belongsTo(Modulos::class, 'fk_modulo');
    }

    public function permisos()
    {
        return $this->hasMany(Permisos::class, 'fk_ruta');
    }
}
