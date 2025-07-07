<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    use HasFactory;

    protected $table = 'movimientos';
    protected $primaryKey = 'id_movimiento';

    protected $fillable = [
        'descripcion',
        'cantidad',
        'hora_ingreso',
        'hora_salida',
        'aceptado',
        'en_proceso',
        'cancelado',
        'devolutivo',
        'no_devolutivo',
        'fecha_devolucion',
        'lugar_destino',
        'fk_inventario',
        'fk_sitio',
        'fk_tipo_movimiento',
        'fk_usuario'
    ];

    protected $casts = [
        'aceptado' => 'boolean',
        'en_proceso' => 'boolean',
        'cancelado' => 'boolean',
        'devolutivo' => 'boolean',
        'no_devolutivo' => 'boolean',
        'fecha_devolucion' => 'date',
    ];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'fk_inventario');
    }

    public function sitio()
    {
        return $this->belongsTo(Sitios::class, 'fk_sitio');
    }

    public function tipoMovimiento()
    {
        return $this->belongsTo(TiposMovimiento::class, 'fk_tipo_movimiento');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'fk_usuario');
    }
}
