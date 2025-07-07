<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificaciones extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';

    protected $fillable = [
        'titulo',
        'mensaje',
        'leido',
        'requiere_accion',
        'estado',
        'data',
        'fk_usuario'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'fk_usuario');
    }
}
