<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoInventario extends Model
{
    use HasFactory;

    protected $table = 'codigo_inventarios';
    protected $primaryKey = 'id_codigo_inventario';

    protected $fillable = ['codigo', 'uso', 'baja', 'fk_inventario'];
    protected $casts = ['uso' => 'boolean', 'baja' => 'boolean'];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'fk_inventario');
    }
}
