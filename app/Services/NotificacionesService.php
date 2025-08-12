<?php

namespace App\Services;

use App\Models\Notificaciones;
use App\Models\Inventario;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class NotificacionesService
{
    /**
     * Crear y guardar una nueva notificación
     */
    public function create(array $data): Notificaciones
    {
        $usuario = User::findOrFail($data['fkUsuario']);

        $notificacion = new Notificaciones();
        $notificacion->titulo = $data['titulo'];
        $notificacion->mensaje = $data['mensaje'];
        $notificacion->requiere_accion = $data['requiere_accion'] ?? false;
        $notificacion->estado = $notificacion->requiere_accion ? ($data['estado'] ?? 'en_proceso') : null;
        $notificacion->data = $data['data'] ?? [];
        $notificacion->fk_usuario = $usuario->id;
        $notificacion->leido = false;
        $notificacion->save();

        // Aquí podrías emitir evento websocket si tienes configurado, por ejemplo:
        // event(new NotificacionCreada($usuario->id, $notificacion));

        Log::info("Notificación creada y enviada a usuario {$usuario->id}");

        return $notificacion;
    }

    /**
     * Obtener todas las notificaciones con usuario relacionadas
     */
    public function findAll(): Collection
    {
        return Notificaciones::with('usuario')->orderByDesc('created_at')->get();
    }

    /**
     * Obtener notificaciones filtradas por usuario y estado del elemento en inventario
     */
    public function getNotificacionesPorUsuario(int $idUsuario): Collection
    {
        $notificaciones = Notificaciones::where('fk_usuario', $idUsuario)
            ->orderByDesc('created_at')
            ->get();

        // Obtener ids de elementos relacionados
        $idsElementos = $notificaciones->pluck('data')->map(function ($data) {
            return $data['id_elemento'] ?? null;
        })->filter()->unique()->values()->all();

        // Obtener inventarios activos para esos elementos
        $inventarios = Inventario::whereIn('fk_elemento', $idsElementos)
            ->where('estado', true)
            ->get()
            ->keyBy('fk_elemento');

        // Filtrar notificaciones: solo las que no tengan idElemento o cuyo inventario esté activo
        return $notificaciones->filter(function ($notificacion) use ($inventarios) {
            $idElemento = $notificacion->data['id_elemento'] ?? null;
            return !$idElemento || isset($inventarios[$idElemento]);
        })->values();
    }

    /**
     * Obtener notificación por id
     */
    public function findOne(int $id): Notificaciones
    {
        $notificacion = Notificaciones::with('usuario')->find($id);

        if (!$notificacion) {
            abort(404, 'Notificación no encontrada');
        }

        return $notificacion;
    }

    /**
     * Actualizar notificación
     */
    public function update(int $id, array $data): Notificaciones
    {
        $notificacion = $this->findOne($id);

        if (isset($data['fkUsuario'])) {
            $data['fk_usuario'] = $data['fkUsuario'];
            unset($data['fkUsuario']);
        }

        $notificacion->update($data);

        return $this->findOne($id);
    }

    /**
     * Marcar notificación como leída
     */
    public function marcarComoLeida(int $id): Notificaciones
    {
        $notificacion = $this->findOne($id);
        $notificacion->leido = true;
        $notificacion->save();

        return $notificacion;
    }

    /**
     * Cambiar estado de notificación (aceptado o cancelado)
     */
    public function cambiarEstado(int $id, string $estado): Notificaciones
    {
        if (!in_array($estado, ['aceptado', 'cancelado'])) {
            abort(400, 'Estado inválido');
        }

        $notificacion = $this->findOne($id);

        if (!$notificacion->requiere_accion) {
            abort(400, 'Esta notificación no requiere acción');
        }

        $notificacion->estado = $estado;
        $notificacion->leido = true;
        $notificacion->save();

        return $notificacion;
    }

    /**
     * Eliminar notificación
     */
    public function remove(int $id): bool
    {
        $notificacion = Notificaciones::find($id);

        if (!$notificacion) {
            abort(404, 'Notificación no encontrada');
        }

        return $notificacion->delete();
    }

    /**
     * Enviar y guardar notificación (emitir evento o websocket aquí si tienes)
     */
    public function enviarYGuardarNotificacion(
        string $titulo,
        string $mensaje,
        bool $requiereAccion,
        User $usuario,
        array $data = [],
        ?string $estado = null
    ): Notificaciones {
        $notificacion = $this->create([
            'titulo' => $titulo,
            'mensaje' => $mensaje,
            'requiere_accion' => $requiereAccion,
            'estado' => $estado,
            'fk_usuario' => $usuario->id,
            'data' => $data,
        ]);

        // Emitir websocket o evento aquí si tienes implementado
        // event(new NotificacionCreada($usuario->id, $notificacion));

        Log::info("Notificación emitida vía websocket a usuario {$usuario->id}");

        return $notificacion;
    }

    /**
     * Notificar movimiento pendiente (ejemplo básico)
     */
    public function notificarMovimientoPendiente($movimiento)
    {
        
        $tipoNombre = strtolower($movimiento->tipo->nombre ?? '');

        if (!in_array($tipoNombre, ['salida', 'prestamo'])) {
            return; // No requiere notificación
        }

        $receptores = User::whereHas('rol', function ($query) {
            $query->whereIn('nombre', ['Administrador', 'Lider']);
        })->get();

        $mensaje = "Movimiento de tipo {$movimiento->tipo->nombre} realizado por el usuario {$movimiento->usuario->nombre}. Requiere revisión.";

        foreach ($receptores as $user) {
            $this->enviarYGuardarNotificacion(
                'Movimiento pendiente',
                $mensaje,
                true,
                $user,
                ['id_movimiento' => $movimiento->id]
            );
        }
    }

    /**
     * Notificar ingreso (ejemplo)
     */
    public function notificarIngreso($movimiento)
    {
        if (strtolower($movimiento->tipo->nombre) !== 'ingreso') {
            return;
        }

        $admins = User::whereHas('rol', fn($q) => $q->where('nombre', 'Administrador'))->get();
        $lider = User::whereHas('rol', fn($q) => $q->where('nombre', 'Lider'))->first();

        $mensaje = "Se realizó el ingreso de {$movimiento->cantidad} elemento(s) \"{$movimiento->elemento->nombre}\" realizado por el usuario {$movimiento->usuario->nombre} al sitio {$movimiento->sitio->nombre}.";

        foreach ($admins as $admin) {
            $this->enviarYGuardarNotificacion(
                'Ingreso registrado',
                $mensaje,
                false,
                $admin,
                ['id_movimiento' => $movimiento->id]
            );
        }

        if ($lider) {
            $this->enviarYGuardarNotificacion(
                'Ingreso registrado',
                $mensaje,
                false,
                $lider,
                ['id_movimiento' => $movimiento->id]
            );
        }
    }

    /**
     * Notificar stock bajo
     */
    public function notificarStockBajo(Inventario $inventario)
{
    $inventario->load('elemento'); // carga la relación

    if (!$inventario->estado || $inventario->stock > 15) {
        return;
    }

    $admins = User::whereHas('rol', fn($q) => $q->where('nombre', 'Administrador'))->get();
    $nombreElemento = $inventario->elemento->nombre ?? 'Desconocido';

    $mensaje = "Elemento con Stock Bajo \"{$nombreElemento}\"";

    foreach ($admins as $admin) {
        $this->enviarYGuardarNotificacion(
            'Stock bajo',
            $mensaje,
            false,
            $admin,
            ['idElemento' => $inventario->elemento->id_elemento]
        );
    }
}


    /**
     * Notificar próxima caducidad
     */
    public function notificarProximaCaducidad(Inventario $inventario)
    {
        if (!$inventario->estado) {
            return;
        }

        $fecha_vencimiento = $inventario->fk_elemento->fecha_vencimiento ?? null;

        if (!$fecha_vencimiento) {
            return;
        }

        $hoy = now();
        $diasRestantes = $hoy->diffInDays($fecha_vencimiento, false);

        if ($diasRestantes <= 7 && $diasRestantes >= 0) {
            $admins = User::whereHas('rol', fn($q) => $q->where('nombre', 'Administrador'))->get();
            $mensaje = "El elemento \"{$inventario->fk_elemento->nombre}\" caduca en {$diasRestantes} días.";

            foreach ($admins as $admin) {
                $this->enviarYGuardarNotificacion(
                    'Elemento por caducar',
                    $mensaje,
                    false,
                    $admin,
                    [
                        'id_elemento' => $inventario->fk_elemento->id,
                        'fechaCaducidad' => $fecha_vencimiento,
                    ]
                );
            }
        }
    }

    /**
     * Notificar movimiento aceptado
     */
    public function notificarMovimientoAceptado($movimiento)
    {
        if (!$movimiento->usuario) {
            return;
        }

        $mensaje = "Tu movimiento de tipo \"{$movimiento->tipo->nombre}\" ha sido aceptado.";

        $this->enviarYGuardarNotificacion(
            'Movimiento aceptado',
            $mensaje,
            false,
            $movimiento->usuario,
            ['idMovimiento' => $movimiento->id]
        );
    }

    /**
     * Notificar préstamo con devolución
     */
    public function notificarPrestamoConDevolucion($movimiento)
    {
        if (!$movimiento->usuario || strtolower($movimiento->tipo->nombre) !== 'prestamo') {
            return;
        }

        $fecha = $movimiento->fecha_devolucion
            ? $movimiento->fecha_devolucion->format('d/m/Y')
            : 'sin fecha definida';

        $mensaje = "Recuerda devolver el elemento \"{$movimiento->elemento->nombre}\" antes del {$fecha}.";

        $this->enviarYGuardarNotificacion(
            'Préstamo registrado',
            $mensaje,
            false,
            $movimiento->usuario,
            [
                'idMovimiento' => $movimiento->id,
                'fechaDevolucion' => $movimiento->fecha_devolucion,
            ]
        );
    }

    /**
     * Verificar todos los inventarios y enviar notificaciones necesarias
     */
    public function verificarInventariosYNotificar()
    {
        $inventarios = Inventario::with('fk_elemento')->get();

        foreach ($inventarios as $inventario) {
            $this->notificarStockBajo($inventario);
            $this->notificarProximaCaducidad($inventario);
        }
    }
}
