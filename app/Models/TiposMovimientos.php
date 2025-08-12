<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposMovimientos extends Model
{
    use HasFactory;

    protected $table = 'tipos_movimientos';
    protected $primaryKey = 'id_tipo';

    protected $fillable = ['nombre', 'estado'];
    protected $casts = ['estado' => 'boolean'];

    public function movimientos()
    {
        return $this->hasMany(Movimientos::class, 'fk_tipo_movimiento');
    }
}
