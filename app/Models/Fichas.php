<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichas extends Model
{
use HasFactory;

    protected $table = 'fichas';
    protected $primaryKey = 'id_ficha';

    protected $fillable = [
        'numero',
        'estado',
        'fk_programa'
    ];

    public function programa()
    {
        return $this->belongsTo(ProgramaFormacion::class, 'fk_programa');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'fk_ficha');
    }
}
