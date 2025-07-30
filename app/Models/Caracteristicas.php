<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caracteristicas extends Model
{
    use HasFactory;

    protected $table = 'caracteristicas';
    protected $primaryKey = 'id_caracteristica';

    protected $fillable = [
        'nombre',
        'simbolo',
    ];

    // Relación con Elemento (si aplica, ejemplo: muchos a uno)
    public function elementos()
    {
        return $this->hasMany(Elementos::class, 'fk_caracteristica', 'id_caracteristica');
    }
}
