<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
   use HasFactory;

    protected $table = 'inventarios';
    protected $primaryKey = 'id_inventario';

    protected $fillable = ['stock', 'estado', 'fk_elemento', 'fk_sitio'];
    protected $casts = ['estado' => 'boolean'];

    public function elemento()
    {
        return $this->belongsTo(Elementos::class, 'fk_elemento');
    }

    public function sitio()
    {
        return $this->belongsTo(Sitios::class, 'fk_sitio');
    }

    public function movimientos()
    {
        return $this->hasMany(Movimientos::class, 'fk_inventario');
    }

    public function codigos()
    {
        return $this->hasMany(CodigoInventario::class, 'fk_inventario');
    }
}
