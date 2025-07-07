<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaFormacion extends Model
{
    use HasFactory;

    protected $table = 'programa_formacion';
    protected $primaryKey = 'id_programa';

    protected $fillable = ['nombre', 'estado', 'fk_area'];
    protected $casts = ['estado' => 'boolean'];

    public function area()
    {
        return $this->belongsTo(Areas::class, 'fk_area');
    }
}
