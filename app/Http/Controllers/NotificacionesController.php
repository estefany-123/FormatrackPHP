<?php

namespace App\Services;

use App\Models\Notificaciones;
use App\Models\User;
use App\Models\Inventario;
use Illuminate\Support\Facades\Log;

class NotificacionService
{
    public function create(array $data)
    {
        $usuario = User::findOrFail($data['fk_usuario']);

        $notificacion = Notificaciones::create([
            'titulo' => $data['titulo'],
            'mensaje' => $data['mensaje'],
            'requiere_accion' => $data['requiere_accion'],
            'estado' => $data['requiere_accion'] ? 'enProceso' : null,
            'data' => $data['data'] ?? [],
            'fk_usuario' => $usuario->id,
        ]);

        $this->emitirWebSocket($usuario->id, $notificacion);

        return $notificacion;
    }

    public function marcarComoLeida($id)
    {
        $notificacion = Notificaciones::findOrFail($id);
        $notificacion->leido = true;
        $notificacion->save();
        return $notificacion;
    }

    public function cambiarEstado($id, $estado)
    {
        $notificacion = Notificaciones::findOrFail($id);
        if (!$notificacion->requiere_accion) {
            throw new \Exception("Esta notificación no requiere acción");
        }

        $notificacion->estado = $estado;
        $notificacion->leido = true;
        $notificacion->save();
        return $notificacion;
    }

    public function notificarMovimientoPendiente(array $movimiento)
    {
        $tipoNombre = strtolower($movimiento['tipo']['nombre'] ?? '');
        if (!in_array($tipoNombre, ['salida', 'prestamo'])) return;

        $usuarios = User::whereHas('rol', function ($q) {
            $q->whereIn('nombre', ['Administrador', 'Lider']);
        })->get();

        $mensaje = "Movimiento de tipo {$movimiento['tipo']['nombre']} por {$movimiento['usuario']['nombre']}. Requiere revisión.";

        foreach ($usuarios as $usuario) {
            $this->enviarYGuardarNotificacion(
                'Movimiento pendiente',
                $mensaje,
                true,
                $usuario,
                ['idMovimiento' => $movimiento['idMovimiento']],
                'enProceso'
            );
        }
    }

    public function notificarIngreso(array $movimiento)
    {
        $tipo = strtolower($movimiento['tipo']['nombre'] ?? '');
        if ($tipo !== 'ingreso') return;

        $usuarios = User::whereHas('rol', function ($q) {
            $q->whereIn('nombre', ['Administrador', 'Lider']);
        })->get();

        $mensaje = "Ingreso de {$movimiento['cantidad']} \"{$movimiento['elemento']['nombre']}\" por {$movimiento['usuario']['nombre']} al sitio {$movimiento['sitio']['nombre']}.";

        foreach ($usuarios as $usuario) {
            $this->enviarYGuardarNotificacion(
                'Ingreso registrado',
                $mensaje,
                false,
                $usuario,
                ['idMovimiento' => $movimiento['id']]
            );
        }
    }

    public function notificarStockBajo(Inventario $inventario)
    {
        if ($inventario->estado !== true || $inventario->stock > 15) return;

        $admins = User::whereHas('rol', fn ($q) => $q->where('nombre', 'Administrador'))->get();
        $mensaje = "Stock bajo del elemento \"{$inventario->elemento->nombre}\".";

        foreach ($admins as $admin) {
            $this->enviarYGuardarNotificacion(
                'Stock bajo',
                $mensaje,
                false,
                $admin,
                ['idElemento' => $inventario->fk_elemento]
            );
        }
    }

    public function notificarProximaCaducidad(Inventario $inventario)
    {
        if ($inventario->estado !== true || !$inventario->elemento?->fecha_vencimiento) return;

        $hoy = now();
        $fecha = new \Carbon\Carbon($inventario->elemento->fecha_vencimiento);
        $dias = $hoy->diffInDays($fecha, false);

        if ($dias <= 7) {
            $admins = User::whereHas('rol', fn ($q) => $q->where('nombre', 'Administrador'))->get();
            $mensaje = "El elemento \"{$inventario->elemento->nombre}\" caduca en {$dias} días.";

            foreach ($admins as $admin) {
                $this->enviarYGuardarNotificacion(
                    'Elemento por caducar',
                    $mensaje,
                    false,
                    $admin,
                    [
                        'idElemento' => $inventario->fk_elemento,
                        'fechaCaducidad' => $inventario->elemento->fecha_vencimiento,
                    ]
                );
            }
        }
    }

    public function verificarInventariosYNotificar()
    {
        $inventarios = Inventario::with('elemento')->get();

        foreach ($inventarios as $inventario) {
            $this->notificarStockBajo($inventario);
            $this->notificarProximaCaducidad($inventario);
        }
    }

    public function enviarYGuardarNotificacion(
        string $titulo,
        string $mensaje,
        bool $requiereAccion,
        User $usuario,
        array $data = [],
        ?string $estado = null
    ) {
        $notificacion = Notificaciones::create([
            'titulo' => $titulo,
            'mensaje' => $mensaje,
            'requiere_accion' => $requiereAccion,
            'estado' => $requiereAccion ? ($estado ?? 'enProceso') : null,
            'data' => $data,
            'leido' => false,
            'fk_usuario' => $usuario->id,
        ]);

        $this->emitirWebSocket($usuario->id, $notificacion);
    }

    protected function emitirWebSocket(int $userId, Notificaciones $notificacion)
    {
        // Puedes usar Laravel Echo, Pusher o WebSockets aquí
        // Por ejemplo:
        // broadcast(new \App\Events\NotificacionEnviada($userId, $notificacion));
        Log::info('🔔 Emitiendo notificación WS', [
            'usuario' => $userId,
            'notificacion' => $notificacion->toArray(),
        ]);
    }
}
