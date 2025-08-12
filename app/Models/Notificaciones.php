<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificaciones extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'id_notificacion';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'mensaje',
        'leido',
        'requiere_accion',
        'estado',
        'data',
        'fk_usuario',
        'created_at',
    ];

    protected $casts = [
        'leido' => 'boolean',
        'requiere_accion' => 'boolean',
        'data' => 'array',
        'created_at' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'fk_usuario', 'id');
    }
}
