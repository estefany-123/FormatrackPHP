<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposSitio extends Model
{
    use HasFactory;

    protected $table = 'tipos_sitios';
    protected $primaryKey = 'id_tipo';

    protected $fillable = ['nombre', 'estado'];
    protected $casts = ['estado' => 'boolean'];

    public function sitios()
    {
        return $this->hasMany(Sitios::class, 'fk_tipo_sitio');
    }
}
