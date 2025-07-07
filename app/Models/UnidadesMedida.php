<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadesMedida extends Model
{
    use HasFactory;

    protected $table = 'unidades_medida';
    protected $primaryKey = 'id_unidad';

    protected $fillable = ['nombre', 'estado'];
    protected $casts = ['estado' => 'boolean'];

    public function elementos()
    {
        return $this->hasMany(Elementos::class, 'fk_unidad_medida');
    }
}
