<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centros extends Model
{
    use HasFactory;

    protected $table = 'centros';
    protected $primaryKey = 'id_centro';

    protected $fillable = ['nombre', 'estado', 'fk_municipio'];
    protected $casts = ['estado' => 'boolean'];

    public function municipio()
    {
        return $this->belongsTo(Municipios::class, 'fk_municipio');
    }

    public function sedes()
    {
        return $this->hasMany(Sedes::class, 'fk_centro');
    }
}
