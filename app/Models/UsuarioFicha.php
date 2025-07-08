<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class UsuarioFicha extends Model
{
    use HasFactory;

    protected $table = 'usuario_fichas';
    protected $primaryKey = 'id_usuario_ficha';

    protected $fillable = ['fk_ficha', 'fk_usuario'];

    public function ficha()
    {
        return $this->belongsTo(Fichas::class, 'fk_ficha');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'fk_usuario');
    }
}
