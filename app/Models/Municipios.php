<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    use HasFactory;

    protected $table = 'municipios';
    protected $primaryKey = 'id_municipio';

    protected $fillable = ['nombre', 'departamento', 'estado'];
    protected $casts = ['estado' => 'boolean'];

    public function centros()
    {
        return $this->hasMany(Centros::class, 'fk_municipio');
    }
}
