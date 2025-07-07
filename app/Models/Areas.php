<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    use HasFactory;

    protected $table = 'areas';
    protected $primaryKey = 'id_area';

    protected $fillable = ['nombre', 'estado', 'fk_sede', 'fk_usuario'];
    protected $casts = ['estado' => 'boolean'];

    public function sede()
    {
        return $this->belongsTo(Sedes::class, 'fk_sede');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'fk_usuario');
    }

    public function sitios()
    {
        return $this->hasMany(Sitios::class, 'fk_area');
    }

    public function programas()
    {
        return $this->hasMany(ProgramaFormacion::class, 'fk_area');
    }
}
