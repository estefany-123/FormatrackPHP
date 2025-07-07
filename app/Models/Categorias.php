<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;

    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';

    protected $fillable = ['nombre', 'codigo_unpsc', 'estado'];
    protected $casts = ['estado' => 'boolean'];

    public function elementos()
    {
        return $this->hasMany(Elementos::class, 'fk_categoria');
    }
}
