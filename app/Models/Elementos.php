<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elementos extends Model
{
    use HasFactory;

    protected $table = 'elementos';
    protected $primaryKey = 'id_elemento';

    protected $fillable = [
        'nombre', 'descripcion', 'perecedero', 'no_perecedero', 'estado',
        'fecha_vencimiento', 'fecha_uso', 'baja', 'imagen_elemento',
        'fk_categoria', 'fk_unidad_medida', 'fk_caracteristica'
    ];

    protected $casts = [
        'perecedero' => 'boolean',
        'no_perecedero' => 'boolean',
        'estado' => 'boolean',
        'baja' => 'boolean',
        'fecha_vencimiento' => 'date',
        'fecha_uso' => 'date',
    ];

    public function unidadMedida()
    {
        return $this->belongsTo(UnidadesMedida::class, 'fk_unidad_medida');
    }

    public function categoria()
    {
        return $this->belongsTo(Categorias::class, 'fk_categoria');
    }

    public function caracteristica()
    {
        return $this->belongsTo(Caracteristicas::class, 'fk_caracteristica');
    }

    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'fk_elemento');
    }
}
