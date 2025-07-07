<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sitios extends Model
{
    use HasFactory;

    protected $table = 'sitios';
    protected $primaryKey = 'id_sitio';

    protected $fillable = [
        'nombre',
        'persona_encargada',
        'ubicacion',
        'estado',
        'fk_area',
        'fk_tipo_sitio'
    ];

    protected $casts = ['estado' => 'boolean'];

    public function area()
    {
        return $this->belongsTo(Areas::class, 'fk_area');
    }

    public function tipoSitio()
    {
        return $this->belongsTo(TiposSitio::class, 'fk_tipo_sitio');
    }

    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'fk_sitio');
    }

    public function movimientos()
    {
        return $this->hasMany(Movimientos::class, 'fk_sitio');
    }
}
