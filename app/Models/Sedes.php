<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sedes extends Model
{
    use HasFactory;

    protected $table = 'sedes';
    protected $primaryKey = 'id_sede';

    protected $fillable = ['nombre', 'estado', 'fk_centro'];
    protected $casts = ['estado' => 'boolean'];

    public function centro()
    {
        return $this->belongsTo(Centros::class, 'fk_centro');
    }

    public function areas()
    {
        return $this->hasMany(Areas::class, 'fk_sede');
    }
}
